<?php

namespace App\Http\Controllers;

use App\Models\FinancialYear;
use App\Models\Payslip;
use App\Models\PayslipItem;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use App\Models\StaffSalary;
use App\Models\TeacherAttendance;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayslipController extends Controller
{
    public function index(Request $request)
    {
        $query = Payslip::with(['teacher.user']);

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('month')) {
            $query->whereMonth('pay_month', date('m', strtotime($request->month)))
                ->whereYear('pay_month', date('Y', strtotime($request->month)));
        }

        $payslips = $query->orderBy('pay_month', 'desc')->get();
        $teachers = Teacher::select('teachers.*')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->with('user')
            ->get();

        return view('payroll.payslips.index', compact('payslips', 'teachers'));
    }

    public function create()
    {
        $teachers = Teacher::select('teachers.*')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->with('user')
            ->get();
        $currentYear = FinancialYear::where('is_current', true)->first();

        return view('payroll.payslips.create', compact('teachers', 'currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'pay_month' => ['required', 'date'],
        ]);

        $teacher = Teacher::findOrFail($request->teacher_id);
        $payMonth = date('Y-m-01', strtotime($request->pay_month));
        $fy = FinancialYear::where('is_current', true)->first();

        // Fetch active salary
        $salary = StaffSalary::where('teacher_id', $teacher->id)->where('is_active', true)->first();
        if (! $salary) {
            return redirect()->back()->withErrors(['error' => 'No active salary found for this staff.']);
        }

        // Prevent duplicate payslip for same month
        $exists = Payslip::where('teacher_id', $teacher->id)->where('pay_month', $payMonth)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'Payslip already exists for this month.']);
        }

        $allowances = StaffAllowance::where('teacher_id', $teacher->id)->where('is_active', true)->get();
        $deductions = StaffDeduction::where('teacher_id', $teacher->id)->where('is_active', true)->get();

        DB::transaction(function () use ($teacher, $salary, $allowances, $deductions, $payMonth, $fy) {
            $allowSum = 0;
            $deductSum = 0;

            $payslip = Payslip::create([
                'teacher_id' => $teacher->id,
                'financial_year_id' => optional($fy)->id,
                'payslip_no' => 'PAY-'.date('Ym', strtotime($payMonth)).'-'.$teacher->id.'-'.rand(1000, 9999),
                'pay_month' => $payMonth,
                'basic_salary' => $salary->basic_salary,
                'generated_by' => Auth::id(),
            ]);

            foreach ($allowances as $a) {
                $amount = $a->is_percentage ? ($salary->basic_salary * ($a->amount / 100)) : $a->amount;
                PayslipItem::create([
                    'payslip_id' => $payslip->id,
                    'type' => 'allowance',
                    'name' => $a->name,
                    'is_percentage' => $a->is_percentage,
                    'value' => $a->amount,
                    'amount' => $amount,
                ]);
                $allowSum += $amount;
            }

            foreach ($deductions as $d) {
                $amount = $d->is_percentage ? ($salary->basic_salary * ($d->amount / 100)) : $d->amount;
                PayslipItem::create([
                    'payslip_id' => $payslip->id,
                    'type' => 'deduction',
                    'name' => $d->name,
                    'is_percentage' => $d->is_percentage,
                    'value' => $d->amount,
                    'amount' => $amount,
                ]);
                $deductSum += $amount;
            }

            $payslip->update([
                'total_allowances' => $allowSum,
                'total_deductions' => $deductSum,
                'net_salary' => $salary->basic_salary + $allowSum - $deductSum,
            ]);
        });

        return redirect()->route('payslips.index')->with('success', 'Payslip generated.');
    }

    public function show(Payslip $payslip)
    {
        $payslip->load(['teacher.user', 'teacher.campus', 'teacher.staffProfile', 'items']);

        return view('payroll.payslips.show', compact('payslip'));
    }

    public function print(Payslip $payslip)
    {
        $payslip->load(['teacher.user', 'teacher.campus', 'teacher.staffProfile', 'items']);

        $nod = null;
        $teacherUserId = optional($payslip->teacher)->user_id;
        if ($teacherUserId && $payslip->pay_month) {
            $nod = TeacherAttendance::where('teacher_id', $teacherUserId)
                ->whereMonth('date', $payslip->pay_month->month)
                ->whereYear('date', $payslip->pay_month->year)
                ->whereIn('status', ['present', 'late', 'half_day', 'leave'])
                ->count();
        }

        $pdf = Pdf::loadView('payroll.payslips.pdf', compact('payslip', 'nod'));

        return $pdf->download('payslip_'.$payslip->payslip_no.'.pdf');
    }

    public function destroy(Payslip $payslip)
    {
        $payslip->delete();

        return redirect()->route('payslips.index')->with('success', 'Payslip deleted.');
    }
}
