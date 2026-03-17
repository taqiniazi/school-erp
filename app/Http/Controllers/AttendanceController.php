<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherAllocation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance records.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isTeacher = $user && $user->hasRole('Teacher');

        $classes = SchoolClass::all();
        $teacher = null;
        $allocations = collect();

        if ($isTeacher) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                abort(403);
            }

            $allocations = TeacherAllocation::where('teacher_id', $teacher->id)->get(['school_class_id', 'section_id']);
            $allowedClassIds = $allocations->pluck('school_class_id')->unique()->values();
            $classes = SchoolClass::whereIn('id', $allowedClassIds)->orderBy('name')->get();
        }

        $selectedClass = $request->input('school_class_id');
        $selectedSection = $request->input('section_id');
        $date = $request->input('date', date('Y-m-d'));

        $attendances = [];
        $sections = [];

        if ($isTeacher && (! $selectedClass || ! $selectedSection) && $allocations->isNotEmpty()) {
            $first = $allocations->sortBy(function ($row) {
                return sprintf('%010d-%010d', (int) $row->school_class_id, (int) $row->section_id);
            })->first();

            return redirect()->route('attendance.index', [
                'school_class_id' => $first->school_class_id,
                'section_id' => $first->section_id,
                'date' => $date,
            ]);
        }

        if ($selectedClass) {
            if ($isTeacher) {
                $allowedSectionIds = $allocations->where('school_class_id', (int) $selectedClass)->pluck('section_id')->unique()->values();
                $sections = Section::where('school_class_id', $selectedClass)->whereIn('id', $allowedSectionIds)->get();
            } else {
                $sections = Section::where('school_class_id', $selectedClass)->get();
            }

            if ($selectedSection) {
                $this->authorizeTeacherForClassSection($selectedClass, $selectedSection);

                $attendances = Attendance::with('student')
                    ->where('school_class_id', $selectedClass)
                    ->where('section_id', $selectedSection)
                    ->whereDate('date', $date)
                    ->get();
            }
        }

        return view('attendance.index', compact('classes', 'sections', 'attendances', 'selectedClass', 'selectedSection', 'date'));
    }

    /**
     * Show form to take attendance.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $isTeacher = $user && $user->hasRole('Teacher');

        $classes = Cache::remember('all_classes', 3600, function () {
            return SchoolClass::all();
        });

        $selectedClass = $request->input('school_class_id');
        $selectedSection = $request->input('section_id');
        $date = $request->input('date', date('Y-m-d'));

        $students = [];
        $sections = [];
        $existingAttendance = [];
        $teacher = null;
        $allocations = collect();

        if ($isTeacher) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                abort(403);
            }

            $allocations = TeacherAllocation::where('teacher_id', $teacher->id)->get(['school_class_id', 'section_id']);
            $allowedClassIds = $allocations->pluck('school_class_id')->unique()->values();
            $classes = SchoolClass::whereIn('id', $allowedClassIds)->orderBy('name')->get();
        }

        if ($isTeacher && (! $selectedClass || ! $selectedSection) && $allocations->isNotEmpty()) {
            $first = $allocations->sortBy(function ($row) {
                return sprintf('%010d-%010d', (int) $row->school_class_id, (int) $row->section_id);
            })->first();

            return redirect()->route('attendance.create', [
                'school_class_id' => $first->school_class_id,
                'section_id' => $first->section_id,
                'date' => $date,
            ]);
        }

        if ($selectedClass) {
            if ($isTeacher) {
                $allowedSectionIds = $allocations->where('school_class_id', (int) $selectedClass)->pluck('section_id')->unique()->values();
                $sections = Section::where('school_class_id', $selectedClass)->whereIn('id', $allowedSectionIds)->get();
            } else {
                $sections = Section::where('school_class_id', $selectedClass)->get();
            }

            if ($selectedSection) {
                $this->authorizeTeacherForClassSection($selectedClass, $selectedSection);

                $students = Student::where('school_class_id', $selectedClass)
                    ->where('section_id', $selectedSection)
                    ->where('status', 'active')
                    ->orderBy('roll_number') // Assuming roll_number is string/int
                    ->orderBy('first_name')
                    ->get();

                $existingAttendance = Attendance::where('school_class_id', $selectedClass)
                    ->where('section_id', $selectedSection)
                    ->whereDate('date', $date)
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('attendance.create', compact('classes', 'sections', 'students', 'existingAttendance', 'selectedClass', 'selectedSection', 'date'));
    }

    /**
     * Store attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late,leave,half_day,holiday',
        ]);

        $date = $request->input('date');
        $classId = $request->input('school_class_id');
        $sectionId = $request->input('section_id');

        $this->authorizeTeacherForClassSection($classId, $sectionId);

        DB::transaction(function () use ($request, $date, $classId, $sectionId) {
            foreach ($request->input('attendances') as $studentId => $data) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'date' => $date,
                        'subject_id' => null, // Daily attendance
                    ],
                    [
                        'school_class_id' => $classId,
                        'section_id' => $sectionId,
                        'status' => $data['status'],
                        'remarks' => $data['remarks'] ?? null,
                        'user_id' => Auth::id(),
                    ]
                );
            }
        });

        return redirect()->route('attendance.index', [
            'school_class_id' => $classId,
            'section_id' => $sectionId,
            'date' => $date,
        ])->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Generate monthly report.
     */
    public function report(Request $request)
    {
        $user = Auth::user();
        $isTeacher = $user && $user->hasRole('Teacher');

        $classes = SchoolClass::all();
        $teacher = null;
        $allocations = collect();

        if ($isTeacher) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                abort(403);
            }

            $allocations = TeacherAllocation::where('teacher_id', $teacher->id)->get(['school_class_id', 'section_id']);
            $allowedClassIds = $allocations->pluck('school_class_id')->unique()->values();
            $classes = SchoolClass::whereIn('id', $allowedClassIds)->orderBy('name')->get();
        }

        $selectedClass = $request->input('school_class_id');
        $selectedSection = $request->input('section_id');
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $sections = [];
        $attendances = [];
        $students = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        if ($isTeacher && (! $selectedClass || ! $selectedSection) && $allocations->isNotEmpty()) {
            $first = $allocations->sortBy(function ($row) {
                return sprintf('%010d-%010d', (int) $row->school_class_id, (int) $row->section_id);
            })->first();

            return redirect()->route('attendance.report', [
                'school_class_id' => $first->school_class_id,
                'section_id' => $first->section_id,
                'month' => $month,
                'year' => $year,
            ]);
        }

        if ($selectedClass) {
            if ($isTeacher) {
                $allowedSectionIds = $allocations->where('school_class_id', (int) $selectedClass)->pluck('section_id')->unique()->values();
                $sections = Section::where('school_class_id', $selectedClass)->whereIn('id', $allowedSectionIds)->get();
            } else {
                $sections = Section::where('school_class_id', $selectedClass)->get();
            }

            if ($selectedSection) {
                $this->authorizeTeacherForClassSection($selectedClass, $selectedSection);

                $students = Student::where('school_class_id', $selectedClass)
                    ->where('section_id', $selectedSection)
                    ->orderBy('roll_number')
                    ->get();

                $attendances = Attendance::where('school_class_id', $selectedClass)
                    ->where('section_id', $selectedSection)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get()
                    ->groupBy('student_id');
            }
        }

        if ($request->has('export_pdf') && $selectedClass && $selectedSection) {
            $className = SchoolClass::find($selectedClass)->name;
            $sectionName = Section::find($selectedSection)->name;

            $pdf = Pdf::loadView('attendance.pdf', compact('students', 'attendances', 'month', 'year', 'daysInMonth', 'className', 'sectionName'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('student_attendance_report_'.$year.'_'.$month.'.pdf');
        }

        return view('attendance.report', compact('classes', 'sections', 'students', 'attendances', 'selectedClass', 'selectedSection', 'month', 'year', 'daysInMonth'));
    }

    private function authorizeTeacherForClassSection($classId, $sectionId): void
    {
        $user = Auth::user();
        if (! $user || ! $user->hasRole('Teacher')) {
            return;
        }

        $teacher = Teacher::where('user_id', $user->id)->first();
        if (! $teacher) {
            abort(403);
        }

        $allowed = TeacherAllocation::where('teacher_id', $teacher->id)
            ->where('school_class_id', $classId)
            ->where('section_id', $sectionId)
            ->exists();

        if (! $allowed) {
            abort(403);
        }
    }
}
