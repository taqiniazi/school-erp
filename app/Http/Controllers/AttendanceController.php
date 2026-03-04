<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance records.
     */
    public function index(Request $request)
    {
        $classes = SchoolClass::all();
        
        $selectedClass = $request->input('school_class_id');
        $selectedSection = $request->input('section_id');
        $date = $request->input('date', date('Y-m-d'));
        
        $attendances = [];
        $sections = [];
        
        if ($selectedClass) {
            $sections = Section::where('school_class_id', $selectedClass)->get();
            
            if ($selectedSection) {
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
        $classes = SchoolClass::all();
        
        $selectedClass = $request->input('school_class_id');
        $selectedSection = $request->input('section_id');
        $date = $request->input('date', date('Y-m-d'));
        
        $students = [];
        $sections = [];
        $existingAttendance = [];
        
        if ($selectedClass) {
            $sections = Section::where('school_class_id', $selectedClass)->get();
            
            if ($selectedSection) {
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
            'attendances.*.status' => 'required|in:present,absent,late,half_day,holiday',
        ]);
        
        $date = $request->input('date');
        $classId = $request->input('school_class_id');
        $sectionId = $request->input('section_id');
        
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
            'date' => $date
        ])->with('success', 'Attendance recorded successfully.');
    }
}
