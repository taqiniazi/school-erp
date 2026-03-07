<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'subscription_id',
        'plan_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'proof_file_path',
        'status',
        'admin_note',
        'invoice_number',
        'invoice_date',
        'subtotal',
        'tax_amount',
        'tax_percentage',
        'billing_details',
    ];

    protected $casts = [
        'billing_details' => 'array',
        'invoice_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
