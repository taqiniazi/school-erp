<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;

class InventoryAlertController extends Controller
{
    public function lowStock()
    {
        $items = InventoryItem::whereColumn('current_stock', '<=', 'reorder_level')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('inventory.alerts.low_stock', compact('items'));
    }
}
