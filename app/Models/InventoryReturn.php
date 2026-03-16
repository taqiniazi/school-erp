<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryReturn extends Model
{
    use BelongsToSchool, HasFactory;

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
