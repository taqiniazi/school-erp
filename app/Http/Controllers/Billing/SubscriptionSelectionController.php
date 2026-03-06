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
        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('billing.choose-plan', [
            'plans' => $plans,
            'school' => $request->user()->school,
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

        Subscription::query()
            ->where('school_id', $school->id)
            ->whereIn('status', ['active', 'trialing'])
            ->update([
                'status' => 'canceled',
                'canceled_at' => now(),
            ]);

        $start = now();
        $end = match ($plan->billing_cycle) {
            'yearly' => $start->copy()->addYear(),
            default => $start->copy()->addMonth(),
        };

        Subscription::create([
            'school_id' => $school->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'current_period_start' => $start,
            'current_period_end' => $end,
        ]);

        return redirect()->route('admin.dashboard');
    }
}
