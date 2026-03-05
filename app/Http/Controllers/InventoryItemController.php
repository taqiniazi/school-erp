<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        $items = InventoryItem::orderBy('name')->paginate(20);
        return view('inventory.items.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:inventory_items,sku'],
            'unit' => ['nullable', 'string', 'max:50'],
            'opening_stock' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $item = InventoryItem::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'unit' => $request->unit,
            'opening_stock' => $request->opening_stock,
            'current_stock' => $request->opening_stock,
            'reorder_level' => $request->reorder_level,
            'status' => $request->status,
        ]);

        return redirect()->route('inventory.items.index')->with('success', 'Item created.');
    }

    public function edit(InventoryItem $inventoryItem)
    {
        return view('inventory.items.edit', ['item' => $inventoryItem]);
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:inventory_items,sku,' . $inventoryItem->id],
            'unit' => ['nullable', 'string', 'max:50'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $inventoryItem->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'status' => $request->status,
        ]);

        return redirect()->route('inventory.items.index')->with('success', 'Item updated.');
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return redirect()->route('inventory.items.index')->with('success', 'Item deleted.');
    }
}

