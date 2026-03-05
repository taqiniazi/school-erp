<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class FeePayment extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'fee_invoice_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'remarks',
        'collected_by'
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
