<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayslipItem extends Model
{
    use BelongsToSchool, HasFactory;

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
