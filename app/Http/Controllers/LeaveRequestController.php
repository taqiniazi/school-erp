<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function myIndex()
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        $requests = LeaveRequest::where('teacher_id', optional($teacher)->id)->orderByDesc('id')->get();

        return view('hr.leave.my_index', compact('requests'));
    }

    public function create()
    {
        return view('hr.leave.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required', 'in:sick,casual,annual,unpaid,other'],
            'reason' => ['nullable', 'string'],
        ]);

        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        LeaveRequest::create([
            'teacher_id' => $teacher->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('hr.leave.my')->with('success', 'Leave request submitted.');
    }

    public function index()
    {
        $requests = LeaveRequest::with('teacher')->orderByDesc('id')->get();

        return view('hr.leave.index', compact('requests'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('hr.leave.index')->with('success', 'Leave approved.');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('hr.leave.index')->with('success', 'Leave rejected.');
    }
}
