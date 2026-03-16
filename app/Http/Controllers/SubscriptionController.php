<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $school = $request->user()->school;
        $subscription = Subscription::where('school_id', $school->id)
            ->whereIn('status', ['active', 'trialing'])
            ->latest()
            ->first();

        // If no active subscription, redirect to choose plan
        if (! $subscription) {
            return redirect()->route('billing.choose-plan');
        }

        $plan = $subscription->plan;

        // Calculate Usage
        $usage = [
            'students' => $school->students()->count(),
            'teachers' => $school->teachers()->count(),
            'campuses' => $school->campuses()->count(),
        ];

        return view('admin.subscription.index', compact('school', 'subscription', 'plan', 'usage'));
    }

    public function upgrade()
    {
        $plans = Plan::where('is_active', true)->orderBy('price')->get();

        return view('billing.choose-plan', [
            'plans' => $plans,
            'school' => auth()->user()->school,
        ]);
    }
}
