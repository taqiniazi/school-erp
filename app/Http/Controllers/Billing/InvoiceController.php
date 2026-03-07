<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function download(SubscriptionPayment $payment)
    {
        // Ensure user belongs to the school that made the payment
        if ($payment->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        // Only approved payments have invoices
        if ($payment->status !== 'approved') {
            abort(404);
        }

        $pdf = PDF::loadView('billing.invoice-pdf', compact('payment'));
        
        return $pdf->download('invoice-' . $payment->transaction_reference . '.pdf');
    }
}
