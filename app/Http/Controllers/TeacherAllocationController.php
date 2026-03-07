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
            ->paginate(10);
            
        $teachers = Teacher::with('user')->get();
        $classes = SchoolClass::with('sections')->get();
        $subjects = Subject::all();
        $sections = Section::all();

        return view('allocations.index', compact('allocations', 'teachers', 'classes', 'subjects', 'sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        TeacherAllocation::create($request->all());

        return redirect()->route('allocations.index')->with('success', 'Teacher allocated successfully.');
    }

    public function destroy(TeacherAllocation $allocation)
    {
        $allocation->delete();
        return redirect()->route('allocations.index')->with('success', 'Allocation removed successfully.');
    }
}
