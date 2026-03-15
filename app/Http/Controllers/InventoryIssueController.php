<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryIssueController extends Controller
{
    public function index()
    {
        $issues = InventoryIssue::with('item')->orderByDesc('issue_date')->get();
        return view('inventory.issues.index', compact('issues'));
    }

    public function create()
    {
        $items = InventoryItem::where('status', 'active')->orderBy('name')->get();
        return view('inventory.issues.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_item_id' => ['required', 'exists:inventory_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'issue_date' => ['required', 'date'],
            'recipient' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {
            $item = InventoryItem::lockForUpdate()->findOrFail($request->inventory_item_id);
            $qty = (int)$request->quantity;
            if ($qty > $item->current_stock) {
                abort(422, 'Insufficient stock.');
            }

            InventoryIssue::create([
                'inventory_item_id' => $item->id,
                'quantity' => $qty,
                'issue_date' => $request->issue_date,
                'recipient' => $request->recipient,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            ]);

            $item->current_stock = $item->current_stock - $qty;
            $item->save();
        });

        return redirect()->route('inventory.issues.index')->with('success', 'Issue recorded and stock updated.');
    }
}
