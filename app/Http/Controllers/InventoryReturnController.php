<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryReturnController extends Controller
{
    public function index()
    {
        $returns = InventoryReturn::with('item')->orderByDesc('return_date')->get();

        return view('inventory.returns.index', compact('returns'));
    }

    public function create()
    {
        $items = InventoryItem::where('status', 'active')->orderBy('name')->get();

        return view('inventory.returns.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_item_id' => ['required', 'exists:inventory_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'return_date' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {
            $ret = InventoryReturn::create([
                'inventory_item_id' => $request->inventory_item_id,
                'quantity' => $request->quantity,
                'return_date' => $request->return_date,
                'reference' => $request->reference,
                'reason' => $request->reason,
                'created_by' => Auth::id(),
            ]);

            $item = InventoryItem::lockForUpdate()->find($ret->inventory_item_id);
            $item->current_stock = $item->current_stock + $ret->quantity;
            $item->save();
        });

        return redirect()->route('inventory.returns.index')->with('success', 'Return recorded and stock updated.');
    }
}
