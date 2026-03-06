<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class InventoryItem extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'name',
        'sku',
        'unit',
        'opening_stock',
        'current_stock',
        'reorder_level',
        'status',
    ];
}

