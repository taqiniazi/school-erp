<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('max_percentage', 'desc')->get();
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        return view('grades.create');
    }

    public function store(Request $request)
    {
        if (is_array($request->input('grades'))) {
            $validated = $request->validate([
                'grades' => ['required', 'array', 'min:1'],
                'grades.*.grade_name' => ['required', 'string', 'max:10', 'distinct', Rule::unique('grades', 'grade_name')],
                'grades.*.min_percentage' => ['required', 'integer', 'min:0', 'max:100'],
                'grades.*.max_percentage' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:100',
                    function ($attribute, $value, $fail) use ($request) {
                        $parts = explode('.', $attribute);
                        $index = $parts[1] ?? null;
                        if ($index === null) {
                            return;
                        }
                        $min = data_get($request->input('grades'), $index . '.min_percentage');
                        if (is_numeric($min) && is_numeric($value) && (int) $value < (int) $min) {
                            $fail('The max percentage must be greater than or equal to the min percentage.');
                        }
                    },
                ],
                'grades.*.remark' => ['nullable', 'string', 'max:255'],
            ]);

            $rows = $validated['grades'];

            DB::transaction(function () use ($rows) {
                foreach ($rows as $row) {
                    Grade::create([
                        'grade_name' => $row['grade_name'],
                        'min_percentage' => $row['min_percentage'],
                        'max_percentage' => $row['max_percentage'],
                        'remark' => $row['remark'] ?? null,
                    ]);
                }
            });

            return redirect()->route('grades.index')->with('success', 'Grades created successfully.');
        }

        $request->validate([
            'grade_name' => 'required|string|max:10|unique:grades,grade_name',
            'min_percentage' => 'required|integer|min:0|max:100',
            'max_percentage' => 'required|integer|min:0|max:100|gte:min_percentage',
            'remark' => 'nullable|string|max:255',
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade_name' => 'required|string|max:10|unique:grades,grade_name,' . $grade->id,
            'min_percentage' => 'required|integer|min:0|max:100',
            'max_percentage' => 'required|integer|min:0|max:100|gte:min_percentage',
            'remark' => 'nullable|string|max:255',
        ]);

        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}
