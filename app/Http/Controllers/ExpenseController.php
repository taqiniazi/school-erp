<?php

namespace App\Http\Controllers;

use App\Models\AccountingTransaction;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountingTransaction::where('type', 'expense')->with('financialYear');

        if ($request->filled('financial_year_id')) {
            $query->where('financial_year_id', $request->financial_year_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(20);
        $years = FinancialYear::orderBy('start_date', 'desc')->get();

        return view('accounting.expense.index', compact('expenses', 'years'));
    }

    public function create()
    {
        $years = FinancialYear::orderBy('start_date', 'desc')->get();
        $currentYear = FinancialYear::where('is_current', true)->first();
        return view('accounting.expense.create', compact('years', 'currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'financial_year_id' => ['required', 'exists:financial_years,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $year = FinancialYear::findOrFail($request->financial_year_id);
        if (!($request->date >= $year->start_date && $request->date <= $year->end_date)) {
            return redirect()->back()->withErrors(['error' => 'Date must be within the selected financial year.'])->withInput();
        }

        AccountingTransaction::create([
            'financial_year_id' => $request->financial_year_id,
            'date' => $request->date,
            'type' => 'expense',
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'reference' => $request->reference,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('accounting.expense.index')->with('success', 'Expense recorded.');
    }

    public function edit(AccountingTransaction $expense)
    {
        $years = FinancialYear::orderBy('start_date', 'desc')->get();
        return view('accounting.expense.edit', compact('expense', 'years'));
    }

    public function update(Request $request, AccountingTransaction $expense)
    {
        $request->validate([
            'financial_year_id' => ['required', 'exists:financial_years,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $year = FinancialYear::findOrFail($request->financial_year_id);
        if (!($request->date >= $year->start_date && $request->date <= $year->end_date)) {
            return redirect()->back()->withErrors(['error' => 'Date must be within the selected financial year.'])->withInput();
        }

        $expense->update([
            'financial_year_id' => $request->financial_year_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'reference' => $request->reference,
        ]);

        return redirect()->route('accounting.expense.index')->with('success', 'Expense updated.');
    }

    public function destroy(AccountingTransaction $expense)
    {
        $expense->delete();
        return redirect()->route('accounting.expense.index')->with('success', 'Expense deleted.');
    }
}

