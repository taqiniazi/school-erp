<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class AccountingTransaction extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'financial_year_id',
        'date',
        'type',
        'amount',
        'category',
        'description',
        'reference',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

