<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $schoolClassId = $request->get('school_class_id');
        $sectionId = $request->get('section_id');

        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $sections = collect();
        if (! empty($schoolClassId)) {
            $sections = Section::where('school_class_id', $schoolClassId)->orderBy('name')->get();
        }

        $query = TimetableEntry::with(['schoolClass', 'section', 'subject', 'teacher.user'])
            ->orderBy('day_of_week')
            ->orderBy('start_time');

        if (! empty($schoolClassId)) {
            $query->where('school_class_id', $schoolClassId);
        }
        if (! empty($sectionId)) {
            $query->where('section_id', $sectionId);
        }

        $entries = $query->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();

        return view('timetable.index', compact('classes', 'sections', 'subjects', 'teachers', 'entries', 'schoolClassId', 'sectionId'));
    }

    public function create(Request $request)
    {
        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();

        return view('timetable.create', compact('classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        TimetableEntry::create($validated);

        return redirect()->route('timetable.index', [
            'school_class_id' => $validated['school_class_id'],
            'section_id' => $validated['section_id'] ?? null,
        ])->with('success', 'Timetable entry added successfully.');
    }

    public function edit(TimetableEntry $entry)
    {
        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();
        $sections = Section::where('school_class_id', $entry->school_class_id)->orderBy('name')->get();

        return view('timetable.edit', compact('entry', 'classes', 'sections', 'subjects', 'teachers'));
    }

    public function update(Request $request, TimetableEntry $entry)
    {
        $validated = $request->validate([
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $entry->update($validated);

        return redirect()->route('timetable.index', [
            'school_class_id' => $validated['school_class_id'],
            'section_id' => $validated['section_id'] ?? null,
        ])->with('success', 'Timetable entry updated successfully.');
    }

    public function destroy(TimetableEntry $entry)
    {
        $schoolClassId = $entry->school_class_id;
        $sectionId = $entry->section_id;

        $entry->delete();

        return redirect()->route('timetable.index', [
            'school_class_id' => $schoolClassId,
            'section_id' => $sectionId,
        ])->with('success', 'Timetable entry deleted successfully.');
    }
}
