<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\InventoryItem;
use App\Models\LeaveRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = SchoolClass::count();
        $monthlyFeeCollection = FeePayment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        // Alerts
        $lowStockItems = InventoryItem::whereColumn('quantity', '<=', 'reorder_level')->count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'monthlyFeeCollection',
            'lowStockItems',
            'pendingLeaveRequests'
        ));
    }
}
