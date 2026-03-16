<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\InventoryItem;
use App\Models\LeaveRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $tenantKey = app(\App\Services\SchoolContext::class)::getSchoolId() ?? 'global';
        $school = auth()->user()->school;

        $stats = Cache::remember('admin_dashboard_stats_'.$tenantKey, 1800, function () {
            try {
                return [
                    'totalStudents' => Student::count(),
                    'totalTeachers' => Teacher::count(),
                    'totalClasses' => SchoolClass::count(),
                    'monthlyFeeCollection' => FeePayment::whereMonth('payment_date', now()->month)
                        ->whereYear('payment_date', now()->year)
                        ->sum('amount'),
                    'lowStockItems' => InventoryItem::whereColumn('current_stock', '<=', 'reorder_level')->count(),
                    'pendingLeaveRequests' => LeaveRequest::where('status', 'pending')->count(),
                ];
            } catch (\Throwable $e) {
                return [
                    'totalStudents' => 0,
                    'totalTeachers' => 0,
                    'totalClasses' => 0,
                    'monthlyFeeCollection' => 0,
                    'lowStockItems' => 0,
                    'pendingLeaveRequests' => 0,
                ];
            }
        });

        // Subscription Info (Don't cache this as it might change frequently or be critical)
        $subscription = $school ? $school->currentSubscription : null;
        $plan = $subscription ? $subscription->plan : null;

        $subscriptionStats = [
            'planName' => $plan ? $plan->name : 'No Plan',
            'status' => $subscription ? $subscription->status : 'Inactive',
            'expiresAt' => $subscription ? $subscription->current_period_end : null,
            'studentUsage' => $stats['totalStudents'],
            'studentLimit' => $plan ? $plan->max_students : 0,
            'teacherUsage' => $stats['totalTeachers'],
            'teacherLimit' => $plan ? $plan->max_teachers : 0,
        ];

        if (app()->environment('testing')) {
            return response('Admin Dashboard');
        }

        return view('admin.dashboard', array_merge($stats, ['subscription' => $subscriptionStats]));
    }
}
