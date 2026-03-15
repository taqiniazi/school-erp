<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Services\SchoolContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::orderBy('name')->get();
        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(Request $request)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('designations', 'name');
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $rows = [];
        if (is_array($request->input('designations'))) {
            $validated = $request->validate([
                'designations' => ['required', 'array', 'min:1'],
                'designations.*.name' => ['required', 'string', 'max:255', 'distinct', $nameRule],
                'designations.*.description' => ['nullable', 'string', 'max:255'],
                'designations.*.is_active' => ['nullable', 'boolean'],
            ]);
            $rows = $validated['designations'];
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
                Designation::create([
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                    'is_active' => (bool) ($row['is_active'] ?? true),
                ]);
            }
        });

        $message = count($rows) > 1 ? 'Designations created successfully.' : 'Designation created successfully.';
        return redirect()->route('designations.index')->with('success', $message);
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('designations', 'name')->ignore($designation->id);
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $designation->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }
}
