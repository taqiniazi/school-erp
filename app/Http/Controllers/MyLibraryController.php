<?php

namespace App\Http\Controllers;

use App\Models\LibraryLoan;
use Illuminate\Support\Facades\Auth;

class MyLibraryController extends Controller
{
    public function index()
    {
        $loans = LibraryLoan::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('library/my/index', compact('loans'));
    }
}
