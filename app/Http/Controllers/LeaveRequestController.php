<?php

namespace App\Http\Controllers;

use App\Models\LeavePolicy;
use App\Models\LeaveRequest;
use App\Models\SalaryDeduction;
use App\Models\StaffSalary;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LeaveRequestController extends Controller
{
    public function myIndex()
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        $requests = LeaveRequest::where('teacher_id', optional($teacher)->id)->orderByDesc('id')->get();

        $year = (int) now()->format('Y');
        $policy = $this->getPolicy('teacher', $year);

        $usedPaid = LeaveRequest::where('teacher_id', optional($teacher)->id)
            ->where('status', 'approved')
            ->whereYear('start_date', $year)
            ->get()
            ->sum(function (LeaveRequest $r) {
                if (! is_null($r->paid_days)) {
                    return (int) $r->paid_days;
                }
                if (! is_null($r->total_days)) {
                    return (int) $r->total_days;
                }

                return $this->workingDaysBetween($r->start_date, $r->end_date, [0]);
            });

        $totalPaid = (int) ($policy->total_paid_leaves ?? 20);
        $remainingPaid = max(0, $totalPaid - $usedPaid);

        return view('hr.leave.my_index', compact('requests', 'year', 'totalPaid', 'usedPaid', 'remainingPaid'));
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
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        $start = $request->date('start_date');
        $end = $request->date('end_date');

        $overlapExists = LeaveRequest::where('teacher_id', $teacher->id)
            ->whereIn('status', ['pending', 'approved'])
            ->whereDate('start_date', '<=', $end)
            ->whereDate('end_date', '>=', $start)
            ->exists();

        if ($overlapExists) {
            return back()
                ->withInput()
                ->withErrors(['start_date' => 'A leave request already exists for the selected date range.']);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('teacher-leaves/'.$teacher->id.'/'.Str::uuid(), 'public');
        }

        LeaveRequest::create([
            'teacher_id' => $teacher->id,
            'start_date' => $start,
            'end_date' => $end,
            'type' => $request->type,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('hr.leave.my')->with('success', 'Leave request submitted.');
    }

    public function index()
    {
        $requests = LeaveRequest::with(['teacher.user', 'approver'])->orderByDesc('id')->get();

        return view('hr.leave.index', compact('requests'));
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $data = $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($leaveRequest, $data) {
            $year = (int) $leaveRequest->start_date->format('Y');
            $policy = $this->getPolicy('teacher', $year);
            $weekendDays = is_array($policy->weekend_days) ? $policy->weekend_days : [0];

            $totalDays = $this->workingDaysBetween($leaveRequest->start_date, $leaveRequest->end_date, $weekendDays);

            $approvedLeaves = LeaveRequest::where('teacher_id', $leaveRequest->teacher_id)
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->where('id', '!=', $leaveRequest->id)
                ->get();

            $usedPaid = $approvedLeaves->sum(function (LeaveRequest $r) use ($weekendDays) {
                if (! is_null($r->paid_days)) {
                    return (int) $r->paid_days;
                }
                if (! is_null($r->total_days)) {
                    return (int) $r->total_days;
                }

                return $this->workingDaysBetween($r->start_date, $r->end_date, $weekendDays);
            });

            $allowedPaid = (int) ($policy->total_paid_leaves ?? 20);
            $remainingPaid = max(0, $allowedPaid - (int) $usedPaid);

            $paidDays = min($totalDays, $remainingPaid);
            $unpaidDays = max(0, $totalDays - $paidDays);

            SalaryDeduction::where('leave_request_id', $leaveRequest->id)->delete();

            $deductionAmount = 0.0;
            if ($unpaidDays > 0) {
                $perMonthDays = $this->splitWorkingDaysByMonth($leaveRequest->start_date, $leaveRequest->end_date, $weekendDays);
                foreach ($perMonthDays as $key => $daysInMonth) {
                    if ($daysInMonth <= 0) {
                        continue;
                    }

                    $yearMonth = explode('-', $key);
                    $y = (int) $yearMonth[0];
                    $m = (int) $yearMonth[1];

                    $unpaidInThisMonth = min($unpaidDays, $daysInMonth);
                    if ($unpaidInThisMonth <= 0) {
                        continue;
                    }

                    $basicSalary = $this->getTeacherBasicSalaryForMonth($leaveRequest->teacher_id, $y, $m);
                    $workingDaysForMonth = $this->getWorkingDaysForMonth($policy, $y, $m, $weekendDays);

                    $amount = $workingDaysForMonth > 0
                        ? round(((float) $basicSalary / (float) $workingDaysForMonth) * (float) $unpaidInThisMonth, 2)
                        : 0.0;

                    SalaryDeduction::create([
                        'teacher_id' => $leaveRequest->teacher_id,
                        'year' => $y,
                        'month' => $m,
                        'type' => 'unpaid_leave',
                        'days' => $unpaidInThisMonth,
                        'amount' => $amount,
                        'leave_request_id' => $leaveRequest->id,
                    ]);

                    $deductionAmount += $amount;
                    $unpaidDays -= $unpaidInThisMonth;
                    if ($unpaidDays <= 0) {
                        break;
                    }
                }
            }

            $leaveRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'remarks' => $data['remarks'] ?? null,
                'total_days' => $totalDays,
                'paid_days' => $paidDays,
                'unpaid_days' => max(0, $totalDays - $paidDays),
                'deduction_amount' => round($deductionAmount, 2),
                'processed_at' => now(),
            ]);
        });

        return redirect()->route('hr.leave.index')->with('success', 'Leave approved.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $data = $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        SalaryDeduction::where('leave_request_id', $leaveRequest->id)->delete();

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'remarks' => $data['remarks'] ?? null,
            'processed_at' => now(),
        ]);

        return redirect()->route('hr.leave.index')->with('success', 'Leave rejected.');
    }

    private function getPolicy(string $scope, int $year): LeavePolicy
    {
        if (! Schema::hasTable('leave_policies')) {
            $policy = new LeavePolicy;
            $policy->scope = $scope;
            $policy->year = $year;
            $policy->total_paid_leaves = 20;
            $policy->weekend_days = [0];

            return $policy;
        }

        return LeavePolicy::firstOrCreate(
            ['scope' => $scope, 'year' => $year],
            ['total_paid_leaves' => 20, 'weekend_days' => [0]]
        );
    }

    private function workingDaysBetween($startDate, $endDate, array $weekendDays): int
    {
        $start = $startDate->copy()->startOfDay();
        $end = $endDate->copy()->startOfDay();
        if ($end->lt($start)) {
            return 0;
        }

        $count = 0;
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            if (! in_array($cursor->dayOfWeek, $weekendDays, true)) {
                $count++;
            }
            $cursor->addDay();
        }

        return $count;
    }

    private function splitWorkingDaysByMonth($startDate, $endDate, array $weekendDays): array
    {
        $start = $startDate->copy()->startOfDay();
        $end = $endDate->copy()->startOfDay();
        if ($end->lt($start)) {
            return [];
        }

        $out = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            if (! in_array($cursor->dayOfWeek, $weekendDays, true)) {
                $key = $cursor->format('Y-m');
                $out[$key] = ($out[$key] ?? 0) + 1;
            }
            $cursor->addDay();
        }

        ksort($out);

        return $out;
    }

    private function getWorkingDaysForMonth(LeavePolicy $policy, int $year, int $month, array $weekendDays): int
    {
        if (! is_null($policy->working_days_per_month)) {
            return max(0, (int) $policy->working_days_per_month);
        }

        $start = now()->setDate($year, $month, 1)->startOfMonth()->startOfDay();
        $end = $start->copy()->endOfMonth()->startOfDay();

        return $this->workingDaysBetween($start, $end, $weekendDays);
    }

    private function getTeacherBasicSalaryForMonth(int $teacherId, int $year, int $month): float
    {
        $monthStart = now()->setDate($year, $month, 1)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $salary = StaffSalary::where('teacher_id', $teacherId)
            ->where('is_active', true)
            ->whereDate('effective_from', '<=', $monthEnd)
            ->where(function ($q) use ($monthStart) {
                $q->whereNull('effective_to')->orWhereDate('effective_to', '>=', $monthStart);
            })
            ->orderByDesc('effective_from')
            ->first();

        if ($salary) {
            return (float) $salary->basic_salary;
        }

        $teacher = Teacher::with('salaryStructure')->find($teacherId);
        if ($teacher && $teacher->salaryStructure) {
            return (float) $teacher->salaryStructure->basic_salary;
        }

        return 0.0;
    }
}
