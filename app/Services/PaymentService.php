<?php

namespace App\Services;

use App\Models\SubscriptionPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Approve a subscription payment and activate the subscription.
     *
     * @param  string|null  $note
     * @return void
     */
    public function approvePayment(SubscriptionPayment $payment, $note = null)
    {
        if ($payment->status === 'approved') {
            Log::info("Payment {$payment->id} is already approved.");

            return;
        }

        DB::transaction(function () use ($payment, $note) {
            // Calculate tax
            $taxPercentage = config('billing.tax_percentage', 0);
            $amount = $payment->amount;

            // Assuming the plan price is inclusive of tax, we back-calculate
            // subtotal = amount / (1 + tax_rate)
            $subtotal = $amount / (1 + ($taxPercentage / 100));
            $taxAmount = $amount - $subtotal;

            // Update payment status and generate invoice details
            $payment->update([
                'status' => 'approved',
                'admin_note' => $note ?? $payment->admin_note,
                'invoice_number' => $this->generateInvoiceNumber($payment),
                'invoice_date' => now(),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'tax_percentage' => $taxPercentage,
                'billing_details' => $this->snapshotBillingDetails($payment->school),
            ]);

            $subscription = $payment->subscription;

            // Cancel other active subscriptions for this school
            $payment->school->subscriptions()
                ->where('id', '!=', $subscription->id)
                ->whereIn('status', ['active', 'trialing'])
                ->update(['status' => 'canceled', 'canceled_at' => now()]);

            // Activate this subscription
            $start = now();
            $end = match ($subscription->plan->billing_cycle) {
                'yearly' => $start->copy()->addYear(),
                default => $start->copy()->addMonth(),
            };

            $subscription->update([
                'status' => 'active',
                'current_period_start' => $start,
                'current_period_end' => $end,
            ]);

            Log::info("Payment {$payment->id} approved and subscription {$subscription->id} activated.");
        });
    }

    /**
     * Generate a unique invoice number.
     * Format: INV-YYYYMMDD-ID
     */
    private function generateInvoiceNumber(SubscriptionPayment $payment)
    {
        return 'INV-'.now()->format('Ymd').'-'.str_pad($payment->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Snapshot billing details from the school.
     */
    private function snapshotBillingDetails($school)
    {
        return [
            'name' => $school->name,
            'address' => $school->address,
            'phone' => $school->phone,
            'email' => $school->email,
            'tax_id' => $school->tax_id,
        ];
    }
}
