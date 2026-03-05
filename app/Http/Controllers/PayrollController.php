<?php

namespace App\Http\Controllers;

use App\Models\StaffSalary;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use App\Models\Teacher;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $salaries = StaffSalary::with('teacher')->where('is_active', true)->orderBy('teacher_id')->get();
        return view('payroll.salaries.index', compact('salaries'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.salaries.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['nullable', 'date'],
            'effective_to' => ['nullable', 'date', 'after:effective_from'],
        ]);

        // Deactivate previous active salary if exists
        StaffSalary::where('teacher_id', $request->teacher_id)->where('is_active', true)->update(['is_active' => false]);

        StaffSalary::create($request->only('teacher_id', 'basic_salary', 'effective_from', 'effective_to') + ['is_active' => true]);

        return redirect()->route('payroll.salaries.index')->with('success', 'Salary structure saved.');
    }

    public function edit(StaffSalary $salary)
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.salaries.edit', compact('salary', 'teachers'));
    }

    public function update(Request $request, StaffSalary $salary)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['nullable', 'date'],
            'effective_to' => ['nullable', 'date', 'after:effective_from'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('is_active') && !$salary->is_active) {
            StaffSalary::where('teacher_id', $request->teacher_id)->where('is_active', true)->where('id', '!=', $salary->id)->update(['is_active' => false]);
        }

        $salary->update([
            'teacher_id' => $request->teacher_id,
            'basic_salary' => $request->basic_salary,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('payroll.salaries.index')->with('success', 'Salary updated.');
    }

    public function destroy(StaffSalary $salary)
    {
        $salary->delete();
        return redirect()->route('payroll.salaries.index')->with('success', 'Salary deleted.');
    }

    // Allowances
    public function allowances(Request $request)
    {
        $teacherId = $request->get('teacher_id');
        $query = StaffAllowance::with('teacher')->where('is_active', true);
        if ($teacherId) $query->where('teacher_id', $teacherId);
        $allowances = $query->orderBy('teacher_id')->get();
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.allowances.index', compact('allowances', 'teachers', 'teacherId'));
    }

    public function createAllowance()
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.allowances.create', compact('teachers'));
    }

    public function storeAllowance(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'name' => ['required', 'string', 'max:255'],
            'is_percentage' => ['nullable', 'boolean'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);
        StaffAllowance::create([
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'is_percentage' => $request->boolean('is_percentage'),
            'amount' => $request->amount,
            'is_active' => true,
        ]);
        return redirect()->route('payroll.allowances.index')->with('success', 'Allowance saved.');
    }

    public function editAllowance(StaffAllowance $allowance)
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.allowances.edit', compact('allowance', 'teachers'));
    }

    public function updateAllowance(Request $request, StaffAllowance $allowance)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'name' => ['required', 'string', 'max:255'],
            'is_percentage' => ['nullable', 'boolean'],
            'amount' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $allowance->update([
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'is_percentage' => $request->boolean('is_percentage'),
            'amount' => $request->amount,
            'is_active' => $request->boolean('is_active'),
        ]);
        return redirect()->route('payroll.allowances.index')->with('success', 'Allowance updated.');
    }

    public function destroyAllowance(StaffAllowance $allowance)
    {
        $allowance->delete();
        return redirect()->route('payroll.allowances.index')->with('success', 'Allowance deleted.');
    }

    // Deductions
    public function deductions(Request $request)
    {
        $teacherId = $request->get('teacher_id');
        $query = StaffDeduction::with('teacher')->where('is_active', true);
        if ($teacherId) $query->where('teacher_id', $teacherId);
        $deductions = $query->orderBy('teacher_id')->get();
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.deductions.index', compact('deductions', 'teachers', 'teacherId'));
    }

    public function createDeduction()
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.deductions.create', compact('teachers'));
    }

    public function storeDeduction(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'name' => ['required', 'string', 'max:255'],
            'is_percentage' => ['nullable', 'boolean'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);
        StaffDeduction::create([
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'is_percentage' => $request->boolean('is_percentage'),
            'amount' => $request->amount,
            'is_active' => true,
        ]);
        return redirect()->route('payroll.deductions.index')->with('success', 'Deduction saved.');
    }

    public function editDeduction(StaffDeduction $deduction)
    {
        $teachers = Teacher::orderBy('first_name')->orderBy('last_name')->get();
        return view('payroll.deductions.edit', compact('deduction', 'teachers'));
    }

    public function updateDeduction(Request $request, StaffDeduction $deduction)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'name' => ['required', 'string', 'max:255'],
            'is_percentage' => ['nullable', 'boolean'],
            'amount' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $deduction->update([
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'is_percentage' => $request->boolean('is_percentage'),
            'amount' => $request->amount,
            'is_active' => $request->boolean('is_active'),
        ]);
        return redirect()->route('payroll.deductions.index')->with('success', 'Deduction updated.');
    }

    public function destroyDeduction(StaffDeduction $deduction)
    {
        $deduction->delete();
        return redirect()->route('payroll.deductions.index')->with('success', 'Deduction deleted.');
    }
}

