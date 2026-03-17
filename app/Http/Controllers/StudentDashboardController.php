<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\ExamSchedule;
use App\Models\FeeInvoice;
use App\Models\Mark;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->studentProfile;

        if (! $student) {
            // Fallback
            $student = \App\Models\Student::where('email', $user->email)->first();
        }

        if (! $student) {
            return view('student.dashboard', [
                'attendancePercentage' => 0,
                'unpaidInvoices' => 0,
                'averageMarks' => 0,
                'upcomingExams' => collect(),
                'upcomingEvents' => collect(),
                'recentNotices' => collect(),
            ]);
        }

        // Cache dashboard data for 15 minutes
        $data = Cache::remember('student_dashboard_'.$student->id, 900, function () use ($student) {
            // KPIs
            $totalAttendance = Attendance::where('student_id', $student->id)->count();
            $presentAttendance = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
            $attendancePercentage = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 1) : 0;

            $unpaidInvoices = FeeInvoice::where('student_id', $student->id)->where('status', 'unpaid')->count();

            $averageMarks = Mark::where('student_id', $student->id)->avg('marks_obtained');
            $averageMarks = $averageMarks ? round($averageMarks, 1) : 0;

            // Alerts
            $upcomingExams = ExamSchedule::where('school_class_id', $student->school_class_id)
                ->where('exam_date', '>=', now()->toDateString())
                ->orderBy('exam_date')
                ->with(['exam', 'subject'])
                ->take(3)
                ->get();

            $upcomingEvents = Event::where('start_date', '>=', now())
                ->orderBy('start_date')
                ->take(3)
                ->get();

            $recentNotices = Notice::whereIn('audience_role', ['all', 'Student'])
                ->latest()
                ->take(3)
                ->get();

            return compact(
                'attendancePercentage',
                'unpaidInvoices',
                'averageMarks',
                'upcomingExams',
                'upcomingEvents',
                'recentNotices'
            );
        });

        return view('student.dashboard', $data);
    }

    /**
     * Show student's own attendance.
     */
    public function myAttendance(Request $request)
    {
        $user = Auth::user();
        $student = null;
        $children = collect();

        if ($user->hasRole('Student')) {
            // The relationship in User model is 'studentProfile'
            $student = $user->studentProfile;

            if (! $student) {
                // Fallback: Try to find by email if relationship not set up or user_id is null
                $student = \App\Models\Student::where('email', $user->email)->first();
            }
        } elseif ($user->hasRole('Parent')) {
            $children = $user->students;

            if ($children->isEmpty()) {
                return redirect()->back()->with('error', 'No students linked to your account.');
            }

            if ($request->has('student_id')) {
                $student = $children->where('id', $request->student_id)->first();
                if (! $student) {
                    return redirect()->back()->with('error', 'Invalid student selected.');
                }
            } else {
                $student = $children->first();
            }
        }

        if (! $student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $attendances = Attendance::where('student_id', $student->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->keyBy(function ($item) {
                return $item->date->format('Y-m-d');
            });

        return view('student.my_attendance', compact('student', 'attendances', 'month', 'year', 'daysInMonth', 'children'));
    }

    /**
     * Show student's invoices.
     */
    public function myInvoices(Request $request)
    {
        $user = Auth::user();
        $student = null;
        $children = collect();

        if ($user->hasRole('Student')) {
            $student = $user->studentProfile;
            if (! $student) {
                $student = \App\Models\Student::where('email', $user->email)->first();
            }
        } elseif ($user->hasRole('Parent')) {
            $children = $user->students;

            if ($children->isEmpty()) {
                return redirect()->back()->with('error', 'No students linked to your account.');
            }

            if ($request->has('student_id')) {
                $student = $children->where('id', $request->student_id)->first();
                if (! $student) {
                    return redirect()->back()->with('error', 'Invalid student selected.');
                }
            } else {
                $student = $children->first();
            }
        }

        if (! $student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $invoices = FeeInvoice::where('student_id', $student->id)
            ->orderBy('issue_date', 'desc')
            ->get();

        return view('student.my_invoices', compact('student', 'invoices', 'children'));
    }
}
