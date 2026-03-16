<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use App\Models\LibraryLoan;

class LibraryReportController extends Controller
{
    public function index()
    {
        $totalBooks = (int) LibraryBook::count();
        $activeBooks = (int) LibraryBook::where('status', 'active')->count();

        $issuedLoansCount = (int) LibraryLoan::where('status', 'issued')->count();

        $overdueLoans = LibraryLoan::with(['book', 'user'])
            ->where('status', 'issued')
            ->whereDate('due_date', '<', now()->toDateString())
            ->orderBy('due_date')
            ->get();

        $overdueCount = (int) $overdueLoans->count();
        $overdueAccruedFine = (float) $overdueLoans->sum(fn (LibraryLoan $loan) => $loan->currentAccruedFine());

        return view('library.reports.index', compact(
            'totalBooks',
            'activeBooks',
            'issuedLoansCount',
            'overdueLoans',
            'overdueCount',
            'overdueAccruedFine',
        ));
    }
}
