<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryPurchaseController extends Controller
{
    public function index()
    {
        $purchases = InventoryPurchase::with('item')->orderByDesc('purchase_date')->get();

        return view('inventory.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $items = InventoryItem::where('status', 'active')->orderBy('name')->get();

        return view('inventory.purchases.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_item_id' => ['required', 'exists:inventory_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'vendor' => ['nullable', 'string', 'max:255'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'purchase_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($request) {
            $purchase = InventoryPurchase::create([
                'inventory_item_id' => $request->inventory_item_id,
                'quantity' => $request->quantity,
                'unit_cost' => $request->unit_cost,
                'vendor' => $request->vendor,
                'reference_no' => $request->reference_no,
                'purchase_date' => $request->purchase_date,
                'created_by' => Auth::id(),
            ]);

            $item = InventoryItem::lockForUpdate()->find($purchase->inventory_item_id);
            $item->current_stock = $item->current_stock + $purchase->quantity;
            $item->save();
        });

        return redirect()->route('inventory.purchases.index')->with('success', 'Purchase recorded and stock updated.');
    }
}
