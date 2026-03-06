<?php

namespace App\Http\Controllers;

use App\Models\StaffProfile;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StaffProfileController extends Controller
{
    public function index()
    {
        // Eager load teacher AND teacher.user to avoid N+1
        $profiles = StaffProfile::with('teacher.user')->get();
        return view('hr.staff.index', compact('profiles'));
    }

    public function create()
    {
        // Fix: Teacher model doesn't have first_name/last_name columns. 
        // Join with users table to sort by name.
        $teachers = Teacher::select('teachers.*')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->with('user')
            ->get();
            
        return view('hr.staff.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'unique:staff_profiles,teacher_id', 'exists:teachers,id'],
            'designation' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'join_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        StaffProfile::create($request->only('teacher_id', 'designation', 'department', 'phone', 'address', 'join_date', 'status'));

        return redirect()->route('hr.staff.index')->with('success', 'Staff profile created.');
    }

    public function edit(StaffProfile $staffProfile)
    {
        // Fix: Teacher model doesn't have first_name/last_name columns.
        $teachers = Teacher::select('teachers.*')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->with('user')
            ->get();
            
        return view('hr.staff.edit', ['profile' => $staffProfile, 'teachers' => $teachers]);
    }

    public function update(Request $request, StaffProfile $staffProfile)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'designation' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'join_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $staffProfile->update($request->only('teacher_id', 'designation', 'department', 'phone', 'address', 'join_date', 'status'));

        return redirect()->route('hr.staff.index')->with('success', 'Staff profile updated.');
    }

    public function destroy(StaffProfile $staffProfile)
    {
        $staffProfile->delete();
        return redirect()->route('hr.staff.index')->with('success', 'Staff profile deleted.');
    }
}

