<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeInvoiceItem extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'fee_invoice_id',
        'fee_type_id',
        'name',
        'amount',
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
