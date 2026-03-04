<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::with(['sections', 'subjects'])->orderBy('numeric_value')->get();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes',
            'numeric_value' => 'required|integer|unique:school_classes',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $schoolClass) // Route model binding will resolve 'class' to SchoolClass
    {
        // $schoolClass variable name must match route parameter name if we use resource route.
        // Resource route uses 'school_class' (singular of school_classes table? No, singular of resource name).
        // If Route::resource('classes', SchoolClassController::class);
        // Then parameter is {class}. So variable should be $class.
        // Let's use $class.
        
        $schoolClass->load(['sections', 'subjects']);
        $allSubjects = Subject::all();
        
        return view('classes.show', compact('schoolClass', 'allSubjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $schoolClass)
    {
        return view('classes.edit', compact('schoolClass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('school_classes')->ignore($schoolClass->id)],
            'numeric_value' => ['required', 'integer', Rule::unique('school_classes')->ignore($schoolClass->id)],
        ]);

        $schoolClass->update($validated);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }

    // Section Management
    public function storeSection(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Check uniqueness for this class
        $exists = Section::where('school_class_id', $schoolClass->id)
            ->where('name', $validated['name'])
            ->exists();
            
        if ($exists) {
            return back()->with('error', 'Section already exists in this class.');
        }

        $schoolClass->sections()->create($validated);

        return back()->with('success', 'Section added successfully.');
    }

    public function destroySection(Section $section)
    {
        $section->delete();
        return back()->with('success', 'Section removed successfully.');
    }

    // Subject Management
    public function storeSubject(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        if ($schoolClass->subjects()->where('subject_id', $validated['subject_id'])->exists()) {
            return back()->with('error', 'Subject already assigned to this class.');
        }

        $schoolClass->subjects()->attach($validated['subject_id']);

        return back()->with('success', 'Subject assigned to class successfully.');
    }

    public function destroySubject(SchoolClass $schoolClass, Subject $subject)
    {
        $schoolClass->subjects()->detach($subject->id);
        return back()->with('success', 'Subject removed from class successfully.');
    }

    /**
     * Get sections for a specific class (JSON).
     */
    public function getSections(SchoolClass $schoolClass)
    {
        return response()->json($schoolClass->sections);
    }

    /**
     * Get subjects for a specific class (JSON).
     */
    public function getSubjects(SchoolClass $schoolClass)
    {
        return response()->json($schoolClass->subjects);
    }
}
