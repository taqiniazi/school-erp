<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

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
