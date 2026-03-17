<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAllocation;
use Illuminate\Http\Request;

class TeacherAllocationController extends Controller
{
    public function index()
    {
        $allocations = TeacherAllocation::with(['teacher.user', 'subject', 'schoolClass', 'section'])
            ->latest()
            ->get();

        $teachers = Teacher::with('user')->get();
        $classes = SchoolClass::with('sections')->get();
        $subjects = Subject::all();
        $sections = Section::all();

        return view('allocations.index', compact('allocations', 'teachers', 'classes', 'subjects', 'sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'school_class_ids' => ['required', 'array', 'min:1'],
            'school_class_ids.*' => ['required', 'integer', 'exists:school_classes,id'],
            'section_ids' => ['required', 'array', 'min:1'],
            'section_ids.*' => ['required', 'integer', 'exists:sections,id'],
            'subject_ids' => ['required', 'array', 'min:1'],
            'subject_ids.*' => ['required', 'integer', 'exists:subjects,id'],
        ]);

        $sections = Section::whereIn('id', $validated['section_ids'])
            ->get(['id', 'school_class_id']);

        $selectedClassIds = array_map('intval', $validated['school_class_ids']);
        $invalidSection = $sections->first(function ($section) use ($selectedClassIds) {
            return ! in_array((int) $section->school_class_id, $selectedClassIds, true);
        });
        if ($invalidSection) {
            return redirect()->route('allocations.index')->with('error', 'One or more selected sections do not belong to the selected classes.');
        }

        $createdCount = 0;
        foreach ($sections as $section) {
            foreach ($validated['subject_ids'] as $subjectId) {
                $allocation = TeacherAllocation::firstOrCreate([
                    'teacher_id' => $validated['teacher_id'],
                    'subject_id' => $subjectId,
                    'school_class_id' => $section->school_class_id,
                    'section_id' => $section->id,
                ]);

                if ($allocation->wasRecentlyCreated) {
                    $createdCount++;
                }
            }
        }

        $message = $createdCount > 0 ? 'Teacher allocated successfully.' : 'No new allocations were created.';

        return redirect()->route('allocations.index')->with('success', $message);
    }

    public function update(Request $request, TeacherAllocation $allocation)
    {
        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
        ]);

        $section = Section::select('id', 'school_class_id')->find($validated['section_id']);
        if (! $section || (int) $section->school_class_id !== (int) $validated['school_class_id']) {
            return redirect()->route('allocations.index')->with('error', 'Selected section does not belong to the selected class.');
        }

        $exists = TeacherAllocation::where('teacher_id', $validated['teacher_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('school_class_id', $validated['school_class_id'])
            ->where('section_id', $validated['section_id'])
            ->where('id', '!=', $allocation->id)
            ->exists();
        if ($exists) {
            return redirect()->route('allocations.index')->with('error', 'This allocation already exists.');
        }

        $allocation->update($validated);

        return redirect()->route('allocations.index')->with('success', 'Allocation updated successfully.');
    }

    public function destroy(TeacherAllocation $allocation)
    {
        $allocation->delete();

        return redirect()->route('allocations.index')->with('success', 'Allocation removed successfully.');
    }
}
