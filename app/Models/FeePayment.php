<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity;

    protected $fillable = [
        'fee_invoice_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'remarks',
        'collected_by',
    ];

    public function invoice()
    {
        return $this->belongsTo(FeeInvoice::class, 'fee_invoice_id');
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }
}
