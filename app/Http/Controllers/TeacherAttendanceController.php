<?php

namespace App\Http\Controllers;

use App\Models\TeacherAttendance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherAttendanceController extends Controller
{
    /**
     * Display teacher attendance records.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        $attendances = TeacherAttendance::with('teacher')
            ->whereDate('date', $date)
            ->get();

        return view('teacher_attendance.index', compact('attendances', 'date'));
    }

    /**
     * Show form to take teacher attendance.
     */
    public function create(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // Get all users with role 'Teacher'
        $teachers = User::role('Teacher')
            ->when(Schema::hasTable('teachers'), function ($q) {
                $q->whereHas('teacherProfile', function ($tq) {
                    $tq->where('status', 'active');
                });
            })
            ->orderBy('name')
            ->get();

        $existingAttendance = TeacherAttendance::whereDate('date', $date)
            ->get()
            ->keyBy('teacher_id');

        return view('teacher_attendance.create', compact('teachers', 'existingAttendance', 'date'));
    }

    /**
     * Store teacher attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.teacher_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:present,absent,late,half_day,holiday,leave',
        ]);

        $date = $request->input('date');

        DB::transaction(function () use ($request, $date) {
            foreach ($request->input('attendances') as $teacherId => $data) {
                TeacherAttendance::updateOrCreate(
                    [
                        'teacher_id' => $teacherId,
                        'date' => $date,
                    ],
                    [
                        'status' => $data['status'],
                        'remarks' => $data['remarks'] ?? null,
                        'user_id' => Auth::id(),
                    ]
                );
            }
        });

        return redirect()->route('teacher-attendance.index', ['date' => $date])
            ->with('success', 'Teacher attendance recorded successfully.');
    }

    /**
     * Generate monthly report for teachers.
     */
    public function report(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $teachers = User::role('Teacher')
            ->when(Schema::hasTable('teachers'), function ($q) {
                $q->whereHas('teacherProfile', function ($tq) {
                    $tq->where('status', 'active');
                });
            })
            ->orderBy('name')
            ->get();

        $attendances = TeacherAttendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->groupBy('teacher_id');

        if ($request->has('export_pdf')) {
            $pdf = Pdf::loadView('teacher_attendance.pdf', compact('teachers', 'attendances', 'month', 'year', 'daysInMonth'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('teacher_attendance_report_'.$year.'_'.$month.'.pdf');
        }

        return view('teacher_attendance.report', compact('teachers', 'attendances', 'month', 'year', 'daysInMonth'));
    }

    /**
     * Show teacher's own attendance.
     */
    public function myAttendance(Request $request)
    {
        $teacher = Auth::user();
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $attendances = TeacherAttendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->keyBy(function ($item) {
                return $item->date->format('Y-m-d');
            });

        return view('teacher_attendance.my_attendance', compact('teacher', 'attendances', 'month', 'year', 'daysInMonth'));
    }
}
