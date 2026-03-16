<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['schoolClass', 'section', 'parents'])->latest()->get();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Cache::remember('all_classes', 3600, function () {
            return SchoolClass::all();
        });

        $campuses = Campus::where('is_active', true)->get();

        // Assuming 'Parent' role exists as per previous tasks
        // Caching parents list might be too heavy if there are thousands, but for now okay.
        $parents = Cache::remember('all_parents_role', 300, function () {
            return User::role('Parent')->get();
        });

        return view('students.create', compact('classes', 'parents', 'campuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check Plan Limits
        $school = auth()->user()->school;
        if (is_array($request->input('students'))) {
            $validated = $request->validate([
                'students' => ['required', 'array', 'min:1'],
                'students.*.first_name' => ['required', 'string', 'max:255'],
                'students.*.last_name' => ['required', 'string', 'max:255'],
                'students.*.admission_number' => ['required', 'string', 'max:255', 'distinct', Rule::unique('students', 'admission_number')],
                'students.*.roll_number' => ['nullable', 'string'],
                'students.*.dob' => ['required', 'date'],
                'students.*.gender' => ['required', 'in:male,female,other'],
                'students.*.school_class_id' => ['required', 'exists:school_classes,id'],
                'students.*.section_id' => ['required', 'exists:sections,id'],
                'students.*.campus_id' => ['nullable', 'exists:campuses,id'],
                'students.*.admission_date' => ['required', 'date'],
                'students.*.address' => ['required', 'string'],
                'students.*.phone' => ['nullable', 'string'],
                'students.*.email' => ['nullable', 'email', 'distinct', Rule::unique('students', 'email')],
                'students.*.parent_id' => ['nullable', 'exists:users,id'],
                'students.*.relation' => ['nullable', 'string', 'max:255'],
                'students.*.photo' => ['nullable', 'image', 'max:2048'],
            ]);

            $rows = $validated['students'];

            $plan = $school?->current_plan;
            if (! $plan) {
                return redirect()->back()->with('error', 'No active plan found for your school. Please contact support.');
            }
            if (! is_null($plan->max_students)) {
                $currentCount = $school->students()->count();
                if ($currentCount + count($rows) > (int) $plan->max_students) {
                    return redirect()->back()->with('error', 'You have reached the maximum number of students allowed by your current plan. Please upgrade your subscription.');
                }
            }

            $admissionNumbers = array_map(fn ($r) => (string) ($r['admission_number'] ?? ''), $rows);
            $dupeAdmission = collect(array_count_values($admissionNumbers))->first(fn ($c) => $c > 1);
            if ($dupeAdmission) {
                return redirect()->back()->with('error', 'Duplicate admission numbers found in your submission.');
            }

            $emails = array_values(array_filter(array_map(fn ($r) => $r['email'] ?? null, $rows)));
            if (count($emails) > 0) {
                $dupeEmail = collect(array_count_values($emails))->first(fn ($c) => $c > 1);
                if ($dupeEmail) {
                    return redirect()->back()->with('error', 'Duplicate student emails found in your submission.');
                }
            }

            DB::transaction(function () use ($rows, $request) {
                foreach ($rows as $idx => $row) {
                    $path = null;
                    if ($request->hasFile("students.$idx.photo")) {
                        $path = $request->file("students.$idx.photo")->store('students', 'public');
                    }

                    $student = Student::create([
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'admission_number' => $row['admission_number'],
                        'roll_number' => $row['roll_number'] ?? null,
                        'dob' => $row['dob'],
                        'gender' => $row['gender'],
                        'school_class_id' => $row['school_class_id'],
                        'section_id' => $row['section_id'],
                        'campus_id' => $row['campus_id'] ?? null,
                        'admission_date' => $row['admission_date'],
                        'address' => $row['address'],
                        'phone' => $row['phone'] ?? null,
                        'email' => $row['email'] ?? null,
                        'photo_path' => $path,
                        'status' => 'active',
                    ]);

                    if (! empty($row['parent_id'])) {
                        $student->parents()->attach($row['parent_id'], [
                            'relation' => $row['relation'] ?? 'Guardian',
                        ]);
                    }
                }
            });

            return redirect()->route('students.index')->with('success', 'Students admitted successfully.');
        }

        if (! $school->canAddStudent()) {
            return redirect()->back()->with('error', 'You have reached the maximum number of students allowed by your current plan. Please upgrade your subscription.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'admission_number' => 'required|string|unique:students',
            'roll_number' => 'nullable|string',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'campus_id' => 'nullable|exists:campuses,id',
            'admission_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|unique:students,email',
            'parent_id' => 'nullable|exists:users,id',
            'relation' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $path = null;
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('students', 'public');
            }

            $student = Student::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'admission_number' => $validated['admission_number'],
                'roll_number' => $validated['roll_number'],
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
                'school_class_id' => $validated['school_class_id'],
                'section_id' => $validated['section_id'],
                'campus_id' => $validated['campus_id'] ?? null,
                'admission_date' => $validated['admission_date'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'photo_path' => $path,
                'status' => 'active',
            ]);

            if (! empty($validated['parent_id'])) {
                $student->parents()->attach($validated['parent_id'], [
                    'relation' => $validated['relation'] ?? 'Guardian',
                ]);
            }
        });

        return redirect()->route('students.index')->with('success', 'Student admitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['schoolClass', 'section', 'parents']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        $sections = Section::where('school_class_id', $student->school_class_id)->get();
        $parents = User::role('Parent')->get();
        $campuses = Campus::where('is_active', true)->get();

        return view('students.edit', compact('student', 'classes', 'sections', 'parents', 'campuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'roll_number' => 'nullable|string',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'campus_id' => 'nullable|exists:campuses,id',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|unique:students,email,'.$student->id,
            'status' => 'required|in:active,graduated,left',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    /**
     * Get sections for a specific class.
     */
    public function getSections(SchoolClass $schoolClass)
    {
        return response()->json($schoolClass->sections);
    }
}
