<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\StudentLeaveRequest;
use App\Models\Teacher;
use App\Models\TeacherAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class StudentLeaveRequestController extends Controller
{
    public function indexForParent(Request $request)
    {
        $user = Auth::user();
        $children = $user->students()->orderBy('first_name')->orderBy('last_name')->get();

        $studentId = $request->input('student_id');
        $tableMissing = ! Schema::hasTable('student_leave_requests')
            || ! Schema::hasColumn('student_leave_requests', 'status');
        $requests = collect();

        if (! $tableMissing) {
            $requests = StudentLeaveRequest::with(['student'])
                ->when($studentId, function ($q) use ($studentId) {
                    $q->where('student_id', $studentId);
                })
                ->whereIn('student_id', $children->pluck('id'))
                ->orderByDesc('id')
                ->get();
        }

        return view('parent.leaves.index', compact('children', 'requests', 'studentId', 'tableMissing'));
    }

    public function createForParent(Request $request)
    {
        $user = Auth::user();
        $children = $user->students()->orderBy('first_name')->orderBy('last_name')->get();
        $selectedStudentId = $request->input('student_id');
        $tableMissing = ! Schema::hasTable('student_leave_requests')
            || ! Schema::hasColumn('student_leave_requests', 'status');

        return view('parent.leaves.create', compact('children', 'selectedStudentId', 'tableMissing'));
    }

    public function storeForParent(Request $request)
    {
        $tableMissing = ! Schema::hasTable('student_leave_requests')
            || ! Schema::hasColumn('student_leave_requests', 'status');

        if ($tableMissing) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Student leave requests table/schema is missing. Run migrations first (php artisan migrate).']);
        }

        $user = Auth::user();
        $childrenIds = $user->students()->pluck('students.id');

        $data = $request->validate([
            'student_id' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        if (! $childrenIds->contains((int) $data['student_id'])) {
            abort(403);
        }

        $student = Student::findOrFail((int) $data['student_id']);

        $start = $request->date('start_date');
        $end = $request->date('end_date');

        $overlapQuery = StudentLeaveRequest::where('student_id', $student->id)
            ->whereDate('start_date', '<=', $end)
            ->whereDate('end_date', '>=', $start);

        if (Schema::hasColumn('student_leave_requests', 'status')) {
            $overlapQuery->whereIn('status', ['pending', 'approved']);
        }

        $overlapExists = $overlapQuery->exists();

        if ($overlapExists) {
            return back()
                ->withInput()
                ->withErrors(['start_date' => 'A leave request already exists for the selected date range.']);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('student-leaves/'.$student->id.'/'.Str::uuid(), 'public');
        }

        StudentLeaveRequest::create([
            'student_id' => $student->id,
            'requested_by' => $user->id,
            'start_date' => $start,
            'end_date' => $end,
            'reason' => $data['reason'],
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('parent.leaves.index')->with('success', 'Leave request submitted.');
    }

    public function indexForApprover(Request $request)
    {
        $status = $request->input('status', 'pending');

        $tableMissing = ! Schema::hasTable('student_leave_requests')
            || ! Schema::hasColumn('student_leave_requests', 'status');
        if ($tableMissing) {
            $requests = collect();

            return view('student_leaves.index', compact('requests', 'status', 'tableMissing'));
        }

        $query = StudentLeaveRequest::with(['student.schoolClass', 'student.section', 'requester', 'approver'])
            ->orderByDesc('id');

        if (Schema::hasColumn('student_leave_requests', 'status')) {
            $query->where('status', $status);
        }

        $user = Auth::user();
        if ($user && $user->hasRole('Teacher')) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                abort(403);
            }

            $allowed = TeacherAllocation::where('teacher_id', $teacher->id)->get(['school_class_id', 'section_id']);

            $query->whereHas('student', function ($q) use ($allowed) {
                $q->where(function ($w) use ($allowed) {
                    foreach ($allowed as $a) {
                        $w->orWhere(function ($or) use ($a) {
                            $or->where('school_class_id', $a->school_class_id)
                                ->where('section_id', $a->section_id);
                        });
                    }
                });
            });
        }

        $requests = $query->get();

        $tableMissing = false;

        return view('student_leaves.index', compact('requests', 'status', 'tableMissing'));
    }

    public function approve(Request $request, $studentLeaveRequest)
    {
        $tableMissing = ! Schema::hasTable('student_leave_requests')
            || ! Schema::hasColumn('student_leave_requests', 'status');

        if ($tableMissing) {
            return redirect()->route('student-leaves.index')
                ->with('error', 'Student leave requests table/schema is missing. Run migrations first (php artisan migrate).');
        }

        $studentLeaveRequest = StudentLeaveRequest::findOrFail($studentLeaveRequest);

        $data = $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        $this->authorizeApproverForStudent($studentLeaveRequest->student);

        DB::transaction(function () use ($studentLeaveRequest, $data) {
            $studentLeaveRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'remarks' => $data['remarks'] ?? null,
            ]);

            $this->applyApprovedLeaveToAttendance($studentLeaveRequest);
        });

        return redirect()->route('student-leaves.index')->with('success', 'Student leave approved.');
    }

    public function reject(Request $request, $studentLeaveRequest)
    {
        $tableMissing = ! Schema::hasTable('student_leave_requests')
            || ! Schema::hasColumn('student_leave_requests', 'status');

        if ($tableMissing) {
            return redirect()->route('student-leaves.index')
                ->with('error', 'Student leave requests table/schema is missing. Run migrations first (php artisan migrate).');
        }

        $studentLeaveRequest = StudentLeaveRequest::findOrFail($studentLeaveRequest);

        $data = $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        $this->authorizeApproverForStudent($studentLeaveRequest->student);

        $studentLeaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'remarks' => $data['remarks'] ?? null,
        ]);

        return redirect()->route('student-leaves.index')->with('success', 'Student leave rejected.');
    }

    private function authorizeApproverForStudent(Student $student): void
    {
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        if ($user->hasAnyRole(['Super Admin', 'School Admin'])) {
            return;
        }

        if ($user->hasRole('Teacher')) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                abort(403);
            }

            $allowed = TeacherAllocation::where('teacher_id', $teacher->id)
                ->where('school_class_id', $student->school_class_id)
                ->where('section_id', $student->section_id)
                ->exists();

            if ($allowed) {
                return;
            }
        }

        abort(403);
    }

    private function applyApprovedLeaveToAttendance(StudentLeaveRequest $leave): void
    {
        $student = $leave->student;
        $cursor = $leave->start_date->copy()->startOfDay();
        $end = $leave->end_date->copy()->startOfDay();

        while ($cursor->lte($end)) {
            $exists = Attendance::where('student_id', $student->id)
                ->whereDate('date', $cursor)
                ->whereNull('subject_id')
                ->exists();

            if (! $exists) {
                Attendance::create([
                    'student_id' => $student->id,
                    'school_class_id' => $student->school_class_id,
                    'section_id' => $student->section_id,
                    'subject_id' => null,
                    'user_id' => Auth::id(),
                    'date' => $cursor->toDateString(),
                    'status' => 'leave',
                    'remarks' => 'Approved leave',
                ]);
            }

            $cursor->addDay();
        }
    }
}
