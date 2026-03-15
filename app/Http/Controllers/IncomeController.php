<?php

namespace App\Http\Controllers;

use App\Models\AccountingTransaction;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountingTransaction::where('type', 'income')->with('financialYear');

        if ($request->filled('financial_year_id')) {
            $query->where('financial_year_id', $request->financial_year_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $incomes = $query->orderBy('date', 'desc')->get();
        $years = FinancialYear::orderBy('start_date', 'desc')->get();

        return view('accounting.income.index', compact('incomes', 'years'));
    }

    public function create()
    {
        $years = FinancialYear::orderBy('start_date', 'desc')->get();
        $currentYear = FinancialYear::where('is_current', true)->first();
        return view('accounting.income.create', compact('years', 'currentYear'));
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
            'type' => 'income',
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'reference' => $request->reference,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('accounting.income.index')->with('success', 'Income recorded.');
    }

    public function edit(AccountingTransaction $income)
    {
        $years = FinancialYear::orderBy('start_date', 'desc')->get();
        return view('accounting.income.edit', compact('income', 'years'));
    }

    public function update(Request $request, AccountingTransaction $income)
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

        $income->update([
            'financial_year_id' => $request->financial_year_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'reference' => $request->reference,
        ]);

        return redirect()->route('accounting.income.index')->with('success', 'Income updated.');
    }

    public function destroy(AccountingTransaction $income)
    {
        $income->delete();
        return redirect()->route('accounting.income.index')->with('success', 'Income deleted.');
    }
}
