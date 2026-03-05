<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        return view('exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'session_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Exam::create($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'session_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $exam->update($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    public function schedules(Exam $exam)
    {
        $exam->load('schedules.schoolClass', 'schedules.subject');
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('exams.schedules', compact('exam', 'classes', 'subjects'));
    }

    public function storeSchedule(Request $request, Exam $exam)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'max_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:0|lte:max_marks',
        ]);

        // Check for duplicate schedule
        $exists = ExamSchedule::where('exam_id', $exam->id)
            ->where('school_class_id', $request->school_class_id)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Schedule for this class and subject already exists.');
        }

        ExamSchedule::create([
            'exam_id' => $exam->id,
            'school_class_id' => $request->school_class_id,
            'subject_id' => $request->subject_id,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_marks' => $request->max_marks,
            'pass_marks' => $request->pass_marks,
        ]);

        return redirect()->back()->with('success', 'Exam schedule added successfully.');
    }

    public function deleteSchedule(ExamSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule removed successfully.');
    }
    
    public function publish(Exam $exam)
    {
        $exam->update(['is_published' => true]);
        return redirect()->back()->with('success', 'Exam results published successfully.');
    }
    
    public function unpublish(Exam $exam)
    {
        $exam->update(['is_published' => false]);
        return redirect()->back()->with('success', 'Exam results unpublished successfully.');
    }
}
