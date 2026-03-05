<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use App\Models\LibraryLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryLoanController extends Controller
{
    public function index()
    {
        $loans = LibraryLoan::with(['book', 'user'])->orderByDesc('created_at')->paginate(20);
        return view('library.loans.index', compact('loans'));
    }

    public function create()
    {
        $books = LibraryBook::where('status', 'active')->where('copies_available', '>', 0)->orderBy('title')->get();
        $borrowers = User::role(['Student', 'Teacher'])->orderBy('name')->get();
        return view('library.loans.create', compact('books', 'borrowers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'library_book_id' => ['required', 'exists:library_books,id'],
            'user_id' => ['required', 'exists:users,id'],
            'due_date' => ['required', 'date', 'after:today'],
            'per_day_fine' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request) {
            $book = LibraryBook::lockForUpdate()->findOrFail($request->library_book_id);
            if ($book->copies_available < 1) {
                abort(422, 'No copies available for this book.');
            }
            $book->copies_available -= 1;
            $book->save();

            LibraryLoan::create([
                'library_book_id' => $book->id,
                'user_id' => $request->user_id,
                'issued_at' => Carbon::now(),
                'due_date' => Carbon::parse($request->due_date),
                'per_day_fine' => $request->per_day_fine ?? 5.00,
                'fine_amount' => 0.00,
                'status' => 'issued',
            ]);
        });

        return redirect()->route('library.loans.index')->with('success', 'Book issued.');
    }

    public function returnBook(LibraryLoan $libraryLoan)
    {
        if ($libraryLoan->status !== 'issued') {
            return redirect()->route('library.loans.index')->with('success', 'Already returned.');
        }

        DB::transaction(function () use ($libraryLoan) {
            $libraryLoan->returned_at = Carbon::now();
            $overdueDays = max(0, $libraryLoan->returned_at->toDateString() > $libraryLoan->due_date->toDateString()
                ? Carbon::parse($libraryLoan->returned_at->toDateString())->diffInDays($libraryLoan->due_date)
                : 0);
            $libraryLoan->fine_amount = $overdueDays * $libraryLoan->per_day_fine;
            $libraryLoan->status = 'returned';
            $libraryLoan->save();

            $book = LibraryBook::lockForUpdate()->findOrFail($libraryLoan->library_book_id);
            $book->copies_available += 1;
            if ($book->copies_available > $book->copies_total) {
                $book->copies_available = $book->copies_total;
            }
            $book->save();
        });

        return redirect()->route('library.loans.index')->with('success', 'Book returned.');
    }
}

