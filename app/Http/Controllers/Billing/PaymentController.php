<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function create(Plan $plan)
    {
        return view('billing.payment', [
            'plan' => $plan,
            'school' => auth()->user()->school,
        ]);
    }

    public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'payment_method' => ['required', 'string', 'in:easypaisa,jazzcash,bank_transfer'],
            'transaction_reference' => ['nullable', 'string', 'max:255'],
            'proof_file' => ['required', 'image', 'max:2048'], // 2MB Max
        ]);

        $school = $request->user()->school;
        
        // Handle File Upload
        $path = $request->file('proof_file')->store('payment_proofs', 'public');

        DB::transaction(function () use ($school, $plan, $request, $path) {
            // Cancel any previous pending subscriptions
            Subscription::where('school_id', $school->id)
                ->where('status', 'pending_approval')
                ->delete(); // Or cancel them

            // Create new pending subscription
            $subscription = Subscription::create([
                'school_id' => $school->id,
                'plan_id' => $plan->id,
                'status' => 'pending_approval',
                'current_period_start' => null, // Will be set on approval
                'current_period_end' => null,
            ]);

            // Create Payment Record
            SubscriptionPayment::create([
                'school_id' => $school->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'payment_method' => $request->payment_method,
                'transaction_reference' => $request->transaction_reference,
                'proof_file_path' => $path,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('billing.payment.pending');
    }

    public function pending()
    {
        return view('billing.pending');
    }
    
    public function history()
    {
        $payments = SubscriptionPayment::with('plan')
            ->where('school_id', auth()->user()->school_id)
            ->latest()
            ->paginate(10);
            
        return view('billing.history', compact('payments'));
    }
}
