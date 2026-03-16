<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use BelongsToSchool, HasFactory;

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
