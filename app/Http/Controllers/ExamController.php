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
        if (is_array($request->input('schedules'))) {
            $validated = $request->validate([
                'schedules' => ['required', 'array', 'min:1'],
                'schedules.*.school_class_id' => ['required', 'exists:school_classes,id'],
                'schedules.*.subject_id' => ['required', 'exists:subjects,id'],
                'schedules.*.exam_date' => ['required', 'date'],
                'schedules.*.start_time' => ['required'],
                'schedules.*.end_time' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $parts = explode('.', $attribute);
                        $index = $parts[1] ?? null;
                        if ($index === null) return;
                        $start = data_get($request->input('schedules'), $index . '.start_time');
                        if ($start && $value && strtotime($value) <= strtotime($start)) {
                            $fail('End time must be after start time.');
                        }
                    },
                ],
                'schedules.*.max_marks' => ['required', 'integer', 'min:1'],
                'schedules.*.pass_marks' => [
                    'required',
                    'integer',
                    'min:0',
                    function ($attribute, $value, $fail) use ($request) {
                        $parts = explode('.', $attribute);
                        $index = $parts[1] ?? null;
                        if ($index === null) return;
                        $max = data_get($request->input('schedules'), $index . '.max_marks');
                        if (is_numeric($max) && is_numeric($value) && (int) $value > (int) $max) {
                            $fail('Pass marks must be less than or equal to max marks.');
                        }
                    },
                ],
            ]);

            $rows = $validated['schedules'];

            $pairCounts = [];
            foreach ($rows as $row) {
                $key = $row['school_class_id'] . ':' . $row['subject_id'];
                $pairCounts[$key] = ($pairCounts[$key] ?? 0) + 1;
            }
            $duplicateKey = collect($pairCounts)->first(fn ($count) => $count > 1);
            if ($duplicateKey) {
                return redirect()->back()->with('error', 'Duplicate schedules found in your submission.');
            }

            $classIds = array_values(array_unique(array_map(fn ($r) => $r['school_class_id'], $rows)));
            $subjectIds = array_values(array_unique(array_map(fn ($r) => $r['subject_id'], $rows)));
            $existingPairs = ExamSchedule::where('exam_id', $exam->id)
                ->whereIn('school_class_id', $classIds)
                ->whereIn('subject_id', $subjectIds)
                ->get(['school_class_id', 'subject_id'])
                ->map(fn ($s) => $s->school_class_id . ':' . $s->subject_id)
                ->flip();

            foreach ($rows as $row) {
                $key = $row['school_class_id'] . ':' . $row['subject_id'];
                if ($existingPairs->has($key)) {
                    return redirect()->back()->with('error', 'Schedule for one or more class/subject pairs already exists.');
                }
            }

            DB::transaction(function () use ($exam, $rows) {
                foreach ($rows as $row) {
                    ExamSchedule::create([
                        'exam_id' => $exam->id,
                        'school_class_id' => $row['school_class_id'],
                        'subject_id' => $row['subject_id'],
                        'exam_date' => $row['exam_date'],
                        'start_time' => $row['start_time'],
                        'end_time' => $row['end_time'],
                        'max_marks' => $row['max_marks'],
                        'pass_marks' => $row['pass_marks'],
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Exam schedules added successfully.');
        }

        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'max_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:0|lte:max_marks',
        ]);

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
