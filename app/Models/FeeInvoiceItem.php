<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class FeeInvoiceItem extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'fee_invoice_id',
        'fee_type_id',
        'name',
        'amount'
    ];

    public function invoice()
    {
        return $this->belongsTo(FeeInvoice::class, 'fee_invoice_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}
