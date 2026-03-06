<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\InventoryItem;
use App\Models\LeaveRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // KPIs - Cached for 30 minutes
        $stats = Cache::remember('admin_dashboard_stats', 1800, function () {
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
        });

        return view('admin.dashboard', $stats);
    }
}
