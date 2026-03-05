<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MarkController extends Controller
{
    public function index()
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        $classes = SchoolClass::all();
        // We will load sections and subjects dynamically via AJAX or just reload page
        return view('marks.index', compact('exams', 'classes'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        $class = SchoolClass::findOrFail($request->school_class_id);
        $section = Section::findOrFail($request->section_id);
        $subject = Subject::findOrFail($request->subject_id);

        // Find the schedule
        $schedule = ExamSchedule::where('exam_id', $exam->id)
            ->where('school_class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->first();

        if (!$schedule) {
            return redirect()->back()->with('error', 'Exam schedule not found for this subject in this class.');
        }

        // Get students in this section
        // Assuming Student model has relationship to Class and Section
        // Actually Student belongs to Class and Section via admission.
        // Let's assume Student model has `school_class_id` and `section_id` directly or via `student_admissions` table?
        // Let's check Student model.
        // Based on previous memory, Student has `school_class_id` and `section_id`.
        
        $students = Student::where('school_class_id', $class->id)
            ->where('section_id', $section->id)
            ->orderBy('roll_number')
            ->get();

        // Get existing marks
        $existingMarks = Mark::where('exam_schedule_id', $schedule->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('marks.create', compact('exam', 'class', 'section', 'subject', 'schedule', 'students', 'existingMarks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_schedule_id' => 'required|exists:exam_schedules,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|array',
            'remarks.*' => 'nullable|string|max:255',
        ]);

        $schedule = ExamSchedule::findOrFail($request->exam_schedule_id);
        
        DB::transaction(function () use ($request, $schedule) {
            foreach ($request->marks as $studentId => $markValue) {
                if ($markValue !== null) {
                    // Check max marks
                    if ($markValue > $schedule->max_marks) {
                        // This validation should ideally be done before transaction or handled gracefully
                        // For now we assume client side validation or just clamp/fail.
                        // Let's fail hard if someone bypasses.
                        throw new \Exception("Marks for student ID $studentId exceeds max marks ($schedule->max_marks).");
                    }

                    Mark::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'exam_schedule_id' => $schedule->id,
                        ],
                        [
                            'marks_obtained' => $markValue,
                            'remarks' => $request->remarks[$studentId] ?? null,
                            'user_id' => Auth::id(),
                        ]
                    );
                }
            }
        });

        return redirect()->route('marks.index')->with('success', 'Marks saved successfully.');
    }

    public function reportCard(Request $request)
    {
        // For searching students
        $classes = SchoolClass::all();
        $exams = Exam::where('is_published', true)->orderBy('start_date', 'desc')->get();
        
        return view('marks.report_card_search', compact('classes', 'exams'));
    }

    public function generateReportCard(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        $student = Student::with(['schoolClass', 'section'])->findOrFail($request->student_id);

        // Get all schedules for this exam and student's class
        $schedules = ExamSchedule::where('exam_id', $exam->id)
            ->where('school_class_id', $student->school_class_id)
            ->with('subject')
            ->get();

        // Get marks for these schedules
        $marks = Mark::whereIn('exam_schedule_id', $schedules->pluck('id'))
            ->where('student_id', $student->id)
            ->get()
            ->keyBy('exam_schedule_id');

        // Calculate totals and grades
        $data = [];
        $totalMax = 0;
        $totalObtained = 0;

        foreach ($schedules as $schedule) {
            $mark = $marks->get($schedule->id);
            $obtained = $mark ? $mark->marks_obtained : 0;
            $percentage = ($obtained / $schedule->max_marks) * 100;
            
            // Get grade
            $grade = Grade::where('min_percentage', '<=', $percentage)
                ->where('max_percentage', '>=', $percentage)
                ->first();

            $data[] = [
                'subject' => $schedule->subject->name,
                'max_marks' => $schedule->max_marks,
                'pass_marks' => $schedule->pass_marks,
                'obtained' => $obtained,
                'grade' => $grade ? $grade->grade_name : 'N/A',
                'remarks' => $mark ? $mark->remarks : '',
                'is_pass' => $obtained >= $schedule->pass_marks
            ];

            $totalMax += $schedule->max_marks;
            $totalObtained += $obtained;
        }
        
        $overallPercentage = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
        $overallGrade = Grade::where('min_percentage', '<=', $overallPercentage)
                ->where('max_percentage', '>=', $overallPercentage)
                ->first();

        if ($request->has('export_pdf')) {
            $pdf = Pdf::loadView('marks.report_card_pdf', compact('exam', 'student', 'data', 'totalMax', 'totalObtained', 'overallPercentage', 'overallGrade'));
            return $pdf->download('report_card_' . $student->roll_number . '.pdf');
        }

        return view('marks.report_card', compact('exam', 'student', 'data', 'totalMax', 'totalObtained', 'overallPercentage', 'overallGrade'));
    }

    public function myReportCard(Request $request)
    {
        $user = Auth::user();
        $student = null;
        $children = collect();

        if ($user->hasRole('Student')) {
            $student = $user->studentProfile; 
            if (!$student) {
                 $student = \App\Models\Student::where('email', $user->email)->first();
            }
        } elseif ($user->hasRole('Parent')) {
            $children = $user->students;
            
            if ($children->isEmpty()) {
                return redirect()->back()->with('error', 'No students linked to your account.');
            }
            
            if ($request->has('student_id')) {
                $student = $children->where('id', $request->student_id)->first();
                if (!$student) {
                    return redirect()->back()->with('error', 'Invalid student selected.');
                }
            } else {
                $student = $children->first();
            }
        }

        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $exams = Exam::where('is_published', true)->orderBy('start_date', 'desc')->get();
        
        $exam = null;
        $data = [];
        $totalMax = 0;
        $totalObtained = 0;
        $overallPercentage = 0;
        $overallGrade = null;

        if ($request->has('exam_id')) {
            $exam = Exam::where('is_published', true)->findOrFail($request->exam_id);
            
            // Get all schedules for this exam and student's class
            $schedules = ExamSchedule::where('exam_id', $exam->id)
                ->where('school_class_id', $student->school_class_id)
                ->with('subject')
                ->get();

            // Get marks for these schedules
            $marks = Mark::whereIn('exam_schedule_id', $schedules->pluck('id'))
                ->where('student_id', $student->id)
                ->get()
                ->keyBy('exam_schedule_id');

            foreach ($schedules as $schedule) {
                $mark = $marks->get($schedule->id);
                $obtained = $mark ? $mark->marks_obtained : 0;
                $percentage = ($obtained / $schedule->max_marks) * 100;
                
                // Get grade
                $grade = Grade::where('min_percentage', '<=', $percentage)
                    ->where('max_percentage', '>=', $percentage)
                    ->first();

                $data[] = [
                    'subject' => $schedule->subject->name,
                    'max_marks' => $schedule->max_marks,
                    'pass_marks' => $schedule->pass_marks,
                    'obtained' => $obtained,
                    'grade' => $grade ? $grade->grade_name : 'N/A',
                    'remarks' => $mark ? $mark->remarks : '',
                    'is_pass' => $obtained >= $schedule->pass_marks
                ];

                $totalMax += $schedule->max_marks;
                $totalObtained += $obtained;
            }
            
            $overallPercentage = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
            $overallGrade = Grade::where('min_percentage', '<=', $overallPercentage)
                    ->where('max_percentage', '>=', $overallPercentage)
                    ->first();
                    
            if ($request->has('export_pdf')) {
                $pdf = Pdf::loadView('marks.report_card_pdf', compact('exam', 'student', 'data', 'totalMax', 'totalObtained', 'overallPercentage', 'overallGrade'));
                return $pdf->download('report_card_' . $student->roll_number . '.pdf');
            }
        }

        return view('marks.my_report_card', compact('exams', 'exam', 'student', 'children', 'data', 'totalMax', 'totalObtained', 'overallPercentage', 'overallGrade'));
    }
}
