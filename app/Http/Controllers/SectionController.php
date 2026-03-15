<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with(['schoolClass', 'campus'])
            ->orderBy('name')
            ->get();

        $classes = SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
        $campuses = Campus::where('is_active', true)->orderBy('name')->get();

        return view('sections.index', compact('sections', 'classes', 'campuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'campus_id' => ['nullable', 'exists:campuses,id'],
        ]);

        Section::create([
            'name' => $validated['name'],
            'school_class_id' => $validated['school_class_id'],
            'campus_id' => $validated['campus_id'] ?? null,
        ]);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'campus_id' => ['nullable', 'exists:campuses,id'],
        ]);

        $section->update([
            'name' => $validated['name'],
            'school_class_id' => $validated['school_class_id'],
            'campus_id' => $validated['campus_id'] ?? null,
        ]);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }
}
