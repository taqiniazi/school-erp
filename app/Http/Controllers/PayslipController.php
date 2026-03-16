<?php

namespace App\Http\Controllers;

use App\Models\FinancialYear;
use App\Models\Payslip;
use App\Models\PayslipItem;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use App\Models\StaffSalary;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
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
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'pay_month' => ['required', 'date'],
        ]);

        $payMonth = date('Y-m-01', strtotime($request->pay_month));
        $fy = FinancialYear::where('is_current', true)->first();

        $teachers = collect();
        if ($request->filled('teacher_id')) {
            $teachers = collect([Teacher::findOrFail($request->teacher_id)]);
        } else {
            $teachers = Teacher::query()
                ->join('users', 'teachers.user_id', '=', 'users.id')
                ->orderBy('users.name')
                ->select('teachers.*')
                ->get();
        }

        $created = 0;
        $skippedExists = 0;
        $skippedNoSalary = 0;

        foreach ($teachers as $teacher) {
            $result = $this->generatePayslipForTeacher($teacher, $payMonth, $fy);
            if ($result === 'created') {
                $created++;
            } elseif ($result === 'exists') {
                $skippedExists++;
            } elseif ($result === 'no_salary') {
                $skippedNoSalary++;
            }
        }

        $parts = [];
        $parts[] = $created.' generated';
        if ($skippedExists) {
            $parts[] = $skippedExists.' already existed';
        }
        if ($skippedNoSalary) {
            $parts[] = $skippedNoSalary.' missing salary';
        }

        return redirect()->route('payslips.index')->with('success', 'Payslip(s): '.implode(', ', $parts).'.');
    }

    private static function calculateAnnualIncomeTax(float $annualIncome): float
    {
        if ($annualIncome <= 600000) {
            return 0;
        }

        if ($annualIncome <= 1200000) {
            return ($annualIncome - 600000) * 0.01;
        }

        if ($annualIncome <= 2200000) {
            return 6000 + (($annualIncome - 1200000) * 0.11);
        }

        if ($annualIncome <= 3200000) {
            return 116000 + (($annualIncome - 2200000) * 0.23);
        }

        if ($annualIncome <= 4100000) {
            return 345000 + (($annualIncome - 3200000) * 0.30);
        }

        return 615000 + (($annualIncome - 4100000) * 0.35);
    }

    private function generatePayslipForTeacher(Teacher $teacher, string $payMonth, ?FinancialYear $fy): string
    {
        $salary = StaffSalary::where('teacher_id', $teacher->id)->where('is_active', true)->first();
        if (! $salary) {
            return 'no_salary';
        }

        $exists = Payslip::where('teacher_id', $teacher->id)->where('pay_month', $payMonth)->exists();
        if ($exists) {
            return 'exists';
        }

        $allowances = StaffAllowance::where('teacher_id', $teacher->id)->where('is_active', true)->get();
        $deductions = StaffDeduction::where('teacher_id', $teacher->id)->where('is_active', true)->get();

        DB::transaction(function () use ($teacher, $salary, $allowances, $deductions, $payMonth, $fy) {
            $allowSum = 0;
            $deductSum = 0;
            $hasManualIncomeTax = $deductions->contains(function ($d) {
                return strtolower(trim((string) $d->name)) === 'income tax';
            });

            $payslip = Payslip::create([
                'teacher_id' => $teacher->id,
                'financial_year_id' => optional($fy)->id,
                'payslip_no' => 'PAY-'.date('Ym', strtotime($payMonth)).'-'.$teacher->id.'-'.rand(1000, 9999),
                'pay_month' => $payMonth,
                'basic_salary' => $salary->basic_salary,
                'generated_by' => Auth::id(),
            ]);

            foreach ($allowances as $a) {
                $amount = $a->is_percentage ? ($salary->basic_salary * ((float) $a->amount / 100)) : (float) $a->amount;
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

            if (! $hasManualIncomeTax) {
                $annualTaxableIncome = ((float) $salary->basic_salary + (float) $allowSum) * 12;
                $annualIncomeTax = self::calculateAnnualIncomeTax($annualTaxableIncome);
                $monthlyIncomeTax = round($annualIncomeTax / 12, 2);

                if ($monthlyIncomeTax > 0) {
                    PayslipItem::create([
                        'payslip_id' => $payslip->id,
                        'type' => 'deduction',
                        'name' => 'Income Tax',
                        'is_percentage' => false,
                        'value' => 0,
                        'amount' => $monthlyIncomeTax,
                    ]);
                    $deductSum += $monthlyIncomeTax;
                }
            }

            foreach ($deductions as $d) {
                $amount = $d->is_percentage ? ($salary->basic_salary * ((float) $d->amount / 100)) : (float) $d->amount;
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

        return 'created';
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
