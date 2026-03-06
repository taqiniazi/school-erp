<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class InventoryPurchase extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'inventory_item_id',
        'quantity',
        'unit_cost',
        'vendor',
        'reference_no',
        'purchase_date',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}

