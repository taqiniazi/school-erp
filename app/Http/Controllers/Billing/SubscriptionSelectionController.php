<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionSelectionController extends Controller
{
    public function create(Request $request)
    {
        $school = $request->user()->school;

        // Check if there is a pending subscription
        $pendingSubscription = Subscription::where('school_id', $school->id)
            ->where('status', 'pending_approval')
            ->first();

        if ($pendingSubscription) {
            return redirect()->route('billing.payment.pending');
        }

        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('billing.choose-plan', [
            'plans' => $plans,
            'school' => $school,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $school = $request->user()->school;
        abort_unless($school && $school->is_active, 403);

        $plan = Plan::query()
            ->where('is_active', true)
            ->findOrFail($data['plan_id']);

        // Redirect to payment page with selected plan
        return redirect()->route('billing.payment.create', ['plan' => $plan->id]);
    }
}
