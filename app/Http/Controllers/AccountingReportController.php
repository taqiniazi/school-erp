<?php

namespace App\Http\Controllers;

use App\Models\AccountingTransaction;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingReportController extends Controller
{
    public function profitLoss(Request $request)
    {
        $years = FinancialYear::orderBy('start_date', 'desc')->get();
        $selectedYear = null;
        $start = null;
        $end = null;

        if ($request->filled('financial_year_id')) {
            $selectedYear = FinancialYear::find($request->financial_year_id);
            if ($selectedYear) {
                $start = $selectedYear->start_date;
                $end = $selectedYear->end_date;
            }
        } else {
            $selectedYear = FinancialYear::where('is_current', true)->first();
            if ($selectedYear) {
                $start = $selectedYear->start_date;
                $end = $selectedYear->end_date;
            }
        }

        $query = AccountingTransaction::query();
        if ($start && $end) {
            $query->whereBetween('date', [$start, $end]);
        }

        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $net = $totalIncome - $totalExpense;

        $monthly = (clone $query)
            ->select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as ym"),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
            )
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->map(function ($row) {
                $row->net = $row->income - $row->expense;

                return $row;
            });

        return view('accounting.reports.profit_loss', compact('years', 'selectedYear', 'totalIncome', 'totalExpense', 'net', 'monthly'));
    }
}
