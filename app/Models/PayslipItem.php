<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class PayslipItem extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'payslip_id',
        'type',
        'name',
        'is_percentage',
        'value',
        'amount',
    ];

    protected $casts = [
        'is_percentage' => 'boolean',
        'value' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function payslip()
    {
        return $this->belongsTo(Payslip::class);
    }
}
