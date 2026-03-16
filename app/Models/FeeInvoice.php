<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeInvoice extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity;

    protected $fillable = [
        'student_id',
        'invoice_no',
        'issue_date',
        'due_date',
        'total_amount',
        'paid_amount',
        'fine_amount',
        'discount_amount',
        'status',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function items()
    {
        return $this->hasMany(FeeInvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }

    public function getBalanceAttribute()
    {
        return ($this->total_amount + $this->fine_amount) - ($this->paid_amount + $this->discount_amount);
    }
}
