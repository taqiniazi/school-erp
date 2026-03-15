<?php

namespace App\Http\Controllers;

use App\Models\PerformanceReview;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        $reviews = PerformanceReview::with('teacher')->orderByDesc('review_date')->get();
        return view('hr.performance.index', compact('reviews'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('hr.performance.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'review_date' => ['required', 'date'],
            'score' => ['required', 'numeric', 'min:0', 'max:100'],
            'remarks' => ['nullable', 'string'],
        ]);

        PerformanceReview::create([
            'teacher_id' => $request->teacher_id,
            'review_date' => $request->review_date,
            'score' => $request->score,
            'remarks' => $request->remarks,
            'reviewer_id' => Auth::id(),
        ]);

        return redirect()->route('hr.performance.index')->with('success', 'Review saved.');
    }

    public function edit(PerformanceReview $performanceReview)
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('hr.performance.edit', ['review' => $performanceReview, 'teachers' => $teachers]);
    }

    public function update(Request $request, PerformanceReview $performanceReview)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'review_date' => ['required', 'date'],
            'score' => ['required', 'numeric', 'min:0', 'max:100'],
            'remarks' => ['nullable', 'string'],
        ]);

        $performanceReview->update([
            'teacher_id' => $request->teacher_id,
            'review_date' => $request->review_date,
            'score' => $request->score,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('hr.performance.index')->with('success', 'Review updated.');
    }

    public function destroy(PerformanceReview $performanceReview)
    {
        $performanceReview->delete();
        return redirect()->route('hr.performance.index')->with('success', 'Review deleted.');
    }
}
