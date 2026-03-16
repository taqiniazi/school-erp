<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use App\Services\SchoolContext;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamTypeController extends Controller
{
    public function index()
    {
        $examTypes = ExamType::orderBy('name')->get();

        return view('exam-types.index', compact('examTypes'));
    }

    public function create()
    {
        return view('exam-types.create');
    }

    public function store(Request $request)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('exam_types', 'name');
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ExamType::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('exam-types.index')->with('success', 'Exam type created.');
    }

    public function edit(ExamType $examType)
    {
        return view('exam-types.edit', compact('examType'));
    }

    public function update(Request $request, ExamType $examType)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('exam_types', 'name')->ignore($examType->id);
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $examType->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('exam-types.index')->with('success', 'Exam type updated.');
    }

    public function destroy(ExamType $examType)
    {
        $examType->delete();

        return redirect()->route('exam-types.index')->with('success', 'Exam type deleted.');
    }
}
