<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function download(SubscriptionPayment $payment)
    {
        // Ensure the user owns the payment or is an admin
        // Note: Super Admins can download any invoice. School Admins can only download their own.
        
        $user = auth()->user();
        
        if ($user->hasRole('Super Admin')) {
            // Allowed
        } elseif ($user->school_id === $payment->school_id) {
            // Allowed
        } else {
            abort(403);
        }

        if ($payment->status !== 'approved') {
            abort(404, 'Invoice not available for pending/rejected payments.');
        }

        $payment->load(['subscription', 'school', 'plan']);

        $pdf = Pdf::loadView('billing.invoice-pdf', compact('payment'));
        
        $filename = 'invoice-' . ($payment->invoice_number ?? $payment->id) . '.pdf';
        
        return $pdf->download($filename);
    }
}
