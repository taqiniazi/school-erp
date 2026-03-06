<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\SalaryStructure;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\TeacherAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Cache;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with(['user', 'salaryStructure', 'allocations.subject', 'allocations.schoolClass', 'allocations.section'])
                        ->latest()
                        ->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salaryStructures = Cache::remember('all_salary_structures', 86400, function () {
            return SalaryStructure::all();
        });
        return view('teachers.create', compact('salaryStructures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'qualification' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'salary_structure_id' => 'nullable|exists:salary_structures,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            
            $user->assignRole('Teacher');

            $path = null;
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('teachers', 'public');
            }

            Teacher::create([
                'user_id' => $user->id,
                'qualification' => $validated['qualification'],
                'joining_date' => $validated['joining_date'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'emergency_contact' => $validated['emergency_contact'],
                'salary_structure_id' => $validated['salary_structure_id'],
                'photo_path' => $path,
                'status' => 'active',
            ]);
        });

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'salaryStructure', 'allocations.subject', 'allocations.schoolClass', 'allocations.section']);
        
        $subjects = Cache::remember('all_subjects', 3600, function () {
            return Subject::all();
        });
        
        $classes = Cache::remember('all_classes', 3600, function () {
            return SchoolClass::all();
        });
        
        return view('teachers.show', compact('teacher', 'subjects', 'classes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        $salaryStructures = SalaryStructure::all();
        return view('teachers.edit', compact('teacher', 'salaryStructures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($teacher->user_id)],
            'qualification' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'salary_structure_id' => 'nullable|exists:salary_structures,id',
            'status' => 'required|in:active,inactive,resigned',
            'photo' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($validated, $request, $teacher) {
            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if ($request->hasFile('photo')) {
                if ($teacher->photo_path) {
                    Storage::disk('public')->delete($teacher->photo_path);
                }
                $validated['photo_path'] = $request->file('photo')->store('teachers', 'public');
            }

            $teacher->update($validated);
        });

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo_path) {
            Storage::disk('public')->delete($teacher->photo_path);
        }
        $teacher->user->delete(); // This cascades to teacher because of foreign key on delete cascade in migration? 
        // Wait, migration said: $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // So deleting user deletes teacher.
        // But if I delete teacher, user remains?
        // Usually we want to delete both or soft delete.
        // Let's delete user.
        
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    public function storeAllocation(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => [
                'required',
                'exists:subjects,id',
                function ($attribute, $value, $fail) use ($request) {
                    $classId = $request->input('school_class_id');
                    if ($classId) {
                         $exists = DB::table('school_class_subject')
                            ->where('school_class_id', $classId)
                            ->where('subject_id', $value)
                            ->exists();
                         if (!$exists) {
                             $fail('The selected subject is not assigned to this class.');
                         }
                    }
                },
            ],
        ]);

        // Check for duplicate allocation
        $exists = TeacherAllocation::where('teacher_id', $teacher->id)
            ->where('subject_id', $validated['subject_id'])
            ->where('school_class_id', $validated['school_class_id'])
            ->where('section_id', $validated['section_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This subject is already assigned to this teacher for the selected class/section.');
        }

        TeacherAllocation::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $validated['subject_id'],
            'school_class_id' => $validated['school_class_id'],
            'section_id' => $validated['section_id'],
        ]);

        return back()->with('success', 'Subject assigned successfully.');
    }

    public function destroyAllocation(TeacherAllocation $allocation)
    {
        $allocation->delete();
        return back()->with('success', 'Assignment removed successfully.');
    }
}
