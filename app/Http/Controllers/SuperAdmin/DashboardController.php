<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSchools = School::count();
        $activeSchools = School::where('is_active', true)->count();
        $suspendedSchools = School::where('is_active', false)->count();
        $adminUsers = User::role('School Admin')->count();
        $activeSubs = Subscription::where('status', 'active')->count();
        $mrr = Subscription::where('status', 'active')->with('plan')->get()->sum(function ($s) {
            return $s->plan ? $s->plan->price : 0;
        });
        $plans = Plan::where('is_active', true)->get();
        $recentSchools = School::latest()->take(10)->get();
        $subscriptions = Subscription::with(['plan', 'school'])->latest()->take(10)->get();

        return view('super-admin.dashboard', [
            'totalSchools' => $totalSchools,
            'activeSchools' => $activeSchools,
            'suspendedSchools' => $suspendedSchools,
            'adminUsers' => $adminUsers,
            'activeSubs' => $activeSubs,
            'mrr' => $mrr,
            'plans' => $plans,
            'recentSchools' => $recentSchools,
            'subscriptions' => $subscriptions,
        ]);
    }
}
