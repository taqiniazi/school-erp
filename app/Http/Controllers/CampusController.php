<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::get();

        return view('campuses.index', compact('campuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check Plan Limits
        $school = auth()->user()->school;
        if (! $school->canAddCampus()) {
            return redirect()->back()->with('error', 'You have reached the maximum number of campuses allowed by your current plan. Please upgrade your subscription.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_main' => 'boolean',
        ]);

        if ($validated['is_main'] ?? false) {
            // Unset other main campuses if this one is main
            Campus::where('is_main', true)->update(['is_main' => false]);
        }

        Campus::create($validated);

        return redirect()->route('campuses.index')->with('success', 'Campus created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campus $campus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campus $campus)
    {
        return view('campuses.edit', compact('campus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_main' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validated['is_main'] ?? false) {
            // Unset other main campuses if this one is main
            Campus::where('id', '!=', $campus->id)->where('is_main', true)->update(['is_main' => false]);
        }

        $campus->update($validated);

        return redirect()->route('campuses.index')->with('success', 'Campus updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campus $campus)
    {
        // Check if campus has students/teachers before deleting?
        // For now, just delete.
        $campus->delete();

        return redirect()->route('campuses.index')->with('success', 'Campus deleted successfully.');
    }
}
