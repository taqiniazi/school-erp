<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'teacher_id',
        'financial_year_id',
        'payslip_no',
        'pay_month',
        'basic_salary',
        'total_allowances',
        'total_deductions',
        'net_salary',
        'generated_by',
    ];

    protected $casts = [
        'pay_month' => 'date',
        'basic_salary' => 'decimal:2',
        'total_allowances' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function items()
    {
        return $this->hasMany(PayslipItem::class);
    }
}
