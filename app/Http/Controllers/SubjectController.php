<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rows = [];
        if (is_array($request->input('subjects'))) {
            $validated = $request->validate([
                'subjects' => ['required', 'array', 'min:1'],
                'subjects.*.name' => ['required', 'string', 'max:255', 'distinct', 'unique:subjects,name'],
                'subjects.*.code' => ['required', 'string', 'max:255', 'distinct', 'unique:subjects,code'],
                'subjects.*.type' => ['required', 'in:theory,practical,both'],
            ]);
            $rows = $validated['subjects'];
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:subjects',
                'code' => 'required|string|max:255|unique:subjects',
                'type' => 'required|in:theory,practical,both',
            ]);
            $rows = [[
                'name' => $validated['name'],
                'code' => $validated['code'],
                'type' => $validated['type'],
            ]];
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                Subject::create([
                    'name' => $row['name'],
                    'code' => $row['code'],
                    'type' => $row['type'],
                ]);
            }
        });
        
        Cache::forget('all_subjects');

        $message = count($rows) > 1 ? 'Subjects created successfully.' : 'Subject created successfully.';
        return redirect()->route('subjects.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'code' => 'required|string|max:255|unique:subjects,code,' . $subject->id,
            'type' => 'required|in:theory,practical,both',
        ]);

        $subject->update($validated);
        
        Cache::forget('all_subjects');

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        
        Cache::forget('all_subjects');
        
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
