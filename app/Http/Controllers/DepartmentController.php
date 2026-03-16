<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\SchoolContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name')->get();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('departments', 'name');
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $rows = [];
        if (is_array($request->input('departments'))) {
            $validated = $request->validate([
                'departments' => ['required', 'array', 'min:1'],
                'departments.*.name' => ['required', 'string', 'max:255', 'distinct', $nameRule],
                'departments.*.description' => ['nullable', 'string', 'max:255'],
                'departments.*.is_active' => ['nullable', 'boolean'],
            ]);
            $rows = $validated['departments'];
        } else {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', $nameRule],
                'description' => ['nullable', 'string', 'max:255'],
                'is_active' => ['nullable', 'boolean'],
            ]);
            $rows = [[
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active' => $validated['is_active'] ?? null,
            ]];
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                Department::create([
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                    'is_active' => (bool) ($row['is_active'] ?? true),
                ]);
            }
        });

        $message = count($rows) > 1 ? 'Departments created successfully.' : 'Department created successfully.';

        return redirect()->route('departments.index')->with('success', $message);
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('departments', 'name')->ignore($department->id);
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $department->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
