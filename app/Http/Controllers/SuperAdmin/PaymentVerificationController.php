<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Notifications\PaymentStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $payments = SubscriptionPayment::with(['school', 'plan'])
            ->latest()
            ->paginate(20);
            
        return view('super-admin.payments.index', compact('payments'));
    }

    public function update(Request $request, SubscriptionPayment $payment)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request, $payment) {
            $payment->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
            ]);

            if ($request->status === 'approved') {
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
            } elseif ($request->status === 'rejected') {
                $payment->subscription->update(['status' => 'canceled']);
            }
        });

        // Send Notification
        $admins = User::role('School Admin')->where('school_id', $payment->school_id)->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new PaymentStatusUpdated($payment));
        }

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}
