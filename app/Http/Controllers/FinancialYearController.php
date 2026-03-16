<?php

namespace App\Http\Controllers;

use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FinancialYearController extends Controller
{
    public function index()
    {
        $years = FinancialYear::orderBy('start_date', 'desc')->get();

        return view('accounting.years.index', compact('years'));
    }

    public function create()
    {
        return view('accounting.years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:financial_years,name'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request) {
            if ($request->boolean('is_current')) {
                FinancialYear::where('is_current', true)->update(['is_current' => false]);
            }
            FinancialYear::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_current' => $request->boolean('is_current'),
            ]);
        });

        return redirect()->route('financial-years.index')->with('success', 'Financial year created.');
    }

    public function edit(FinancialYear $financialYear)
    {
        return view('accounting.years.edit', compact('financialYear'));
    }

    public function update(Request $request, FinancialYear $financialYear)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('financial_years', 'name')->ignore($financialYear->id)],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $financialYear) {
            if ($request->boolean('is_current')) {
                FinancialYear::where('is_current', true)->where('id', '!=', $financialYear->id)->update(['is_current' => false]);
            }
            $financialYear->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_current' => $request->boolean('is_current'),
            ]);
        });

        return redirect()->route('financial-years.index')->with('success', 'Financial year updated.');
    }

    public function setCurrent(FinancialYear $financialYear)
    {
        DB::transaction(function () use ($financialYear) {
            FinancialYear::where('is_current', true)->update(['is_current' => false]);
            $financialYear->update(['is_current' => true]);
        });

        return redirect()->route('financial-years.index')->with('success', 'Current financial year updated.');
    }

    public function destroy(FinancialYear $financialYear)
    {
        if ($financialYear->is_current) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete the current financial year.']);
        }
        $financialYear->delete();

        return redirect()->route('financial-years.index')->with('success', 'Financial year deleted.');
    }
}
