<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class InventoryReturn extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'inventory_item_id',
        'quantity',
        'return_date',
        'reference',
        'reason',
        'created_by',
    ];

    protected $casts = [
        'return_date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}

