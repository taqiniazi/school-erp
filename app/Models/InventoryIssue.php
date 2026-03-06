<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class InventoryIssue extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'inventory_item_id',
        'quantity',
        'issue_date',
        'recipient',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}

