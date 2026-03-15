<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class LessonPlanController extends Controller
{
    public function index(Request $request)
    {
        $schoolClassId = $request->get('school_class_id');
        $sectionId = $request->get('section_id');
        $subjectId = $request->get('subject_id');

        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $sections = collect();
        if (! empty($schoolClassId)) {
            $sections = Section::where('school_class_id', $schoolClassId)->orderBy('name')->get();
        }
        $subjects = Subject::orderBy('name')->get();

        $query = LessonPlan::with(['schoolClass', 'section', 'subject', 'teacher.user'])
            ->orderByDesc('planned_date')
            ->orderByDesc('id');

        if (! empty($schoolClassId)) {
            $query->where('school_class_id', $schoolClassId);
        }
        if (! empty($sectionId)) {
            $query->where('section_id', $sectionId);
        }
        if (! empty($subjectId)) {
            $query->where('subject_id', $subjectId);
        }

        $plans = $query->get();

        return view('lesson-plans.index', compact('classes', 'sections', 'subjects', 'plans', 'schoolClassId', 'sectionId', 'subjectId'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();

        return view('lesson-plans.create', compact('classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'planned_date' => ['required', 'date'],
            'topic' => ['required', 'string', 'max:255'],
            'objectives' => ['nullable', 'string'],
            'activities' => ['nullable', 'string'],
            'homework' => ['nullable', 'string'],
            'resources' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        LessonPlan::create($validated);

        return redirect()->route('lesson-plans.index')->with('success', 'Lesson plan created successfully.');
    }

    public function edit(LessonPlan $lessonPlan)
    {
        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();
        $sections = Section::where('school_class_id', $lessonPlan->school_class_id)->orderBy('name')->get();

        return view('lesson-plans.edit', compact('lessonPlan', 'classes', 'sections', 'subjects', 'teachers'));
    }

    public function update(Request $request, LessonPlan $lessonPlan)
    {
        $validated = $request->validate([
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'planned_date' => ['required', 'date'],
            'topic' => ['required', 'string', 'max:255'],
            'objectives' => ['nullable', 'string'],
            'activities' => ['nullable', 'string'],
            'homework' => ['nullable', 'string'],
            'resources' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $lessonPlan->update($validated);

        return redirect()->route('lesson-plans.index')->with('success', 'Lesson plan updated successfully.');
    }

    public function destroy(LessonPlan $lessonPlan)
    {
        $lessonPlan->delete();

        return redirect()->route('lesson-plans.index')->with('success', 'Lesson plan deleted successfully.');
    }
}
