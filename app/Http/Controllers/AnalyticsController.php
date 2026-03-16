<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1. Student Growth (Last 12 months)
        $studentGrowth = Student::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 2. Fee Collection (Last 12 months)
        $feeCollection = FeePayment::select(
            DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month"),
            DB::raw('sum(amount) as total')
        )
            ->where('payment_date', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 3. Attendance Rate (Last 30 days)
        // Assuming status 'present' means present.
        $attendanceData = Attendance::select(
            'date',
            DB::raw('count(*) as total_records'),
            DB::raw("sum(case when status = 'present' then 1 else 0 end) as present_count")
        )
            ->where('date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                $item->rate = $item->total_records > 0 ? round(($item->present_count / $item->total_records) * 100, 2) : 0;

                return $item;
            });

        // 4. Teacher Workload (Top 10 teachers by allocation count)
        $teacherWorkload = Teacher::with('user')
            ->withCount('allocations')
            ->orderByDesc('allocations_count')
            ->take(10)
            ->get()
            ->map(function ($teacher) {
                return [
                    'name' => $teacher->user->name ?? 'Unknown',
                    'count' => $teacher->allocations_count,
                ];
            });

        return view('analytics.index', compact('studentGrowth', 'feeCollection', 'attendanceData', 'teacherWorkload'));
    }
}
