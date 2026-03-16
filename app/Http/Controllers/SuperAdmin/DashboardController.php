<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // School Stats
        $totalSchools = School::count();
        $activeSchools = School::where('is_active', true)->count();
        $suspendedSchools = School::where('is_active', false)->count();

        // User Stats
        $adminUsers = User::role('School Admin')->count();

        // Subscription Stats
        $activeSubs = Subscription::where('status', 'active')->count();
        $trialSubs = Subscription::where('status', 'trialing')->count();

        // Revenue Stats
        // MRR calculation based on active subscriptions
        $mrr = Subscription::where('status', 'active')
            ->with('plan')
            ->get()
            ->sum(function ($s) {
                if (! $s->plan) {
                    return 0;
                }

                // If yearly, divide by 12 for monthly equivalent
                return $s->plan->billing_cycle === 'yearly' ? $s->plan->price / 12 : $s->plan->price;
            });

        $totalRevenue = SubscriptionPayment::where('status', 'approved')->sum('amount');
        $monthlyRevenue = SubscriptionPayment::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $pendingPayments = SubscriptionPayment::where('status', 'pending')->count();

        // Recent Data
        $recentSchools = School::latest()->take(5)->get();
        $recentPayments = SubscriptionPayment::with(['school', 'plan'])
            ->latest()
            ->take(5)
            ->get();

        $recentSubscriptions = Subscription::with(['school', 'plan'])
            ->latest()
            ->take(5)
            ->get();

        // Chart Data - Revenue (Last 6 months)
        $revenueChart = SubscriptionPayment::select(
            DB::raw('sum(amount) as total'),
            DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
        )
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Chart Data - New Schools (Last 6 months)
        $schoolChart = School::select(
            DB::raw('count(*) as count'),
            DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('super-admin.dashboard', compact(
            'totalSchools',
            'activeSchools',
            'suspendedSchools',
            'adminUsers',
            'activeSubs',
            'trialSubs',
            'mrr',
            'totalRevenue',
            'monthlyRevenue',
            'pendingPayments',
            'recentSchools',
            'recentPayments',
            'recentSubscriptions',
            'revenueChart',
            'schoolChart'
        ));
    }
}
