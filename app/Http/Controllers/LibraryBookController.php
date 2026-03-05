<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use Illuminate\Http\Request;

class LibraryBookController extends Controller
{
    public function index()
    {
        $books = LibraryBook::orderBy('title')->paginate(20);
        return view('library.books.index', compact('books'));
    }

    public function create()
    {
        return view('library.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255', 'unique:library_books,isbn'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copies_total' => ['required', 'integer', 'min:0'],
            'shelf' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['copies_available'] = $data['copies_total'];

        LibraryBook::create($data);
        return redirect()->route('library.books.index')->with('success', 'Book created.');
    }

    public function edit(LibraryBook $libraryBook)
    {
        return view('library.books.edit', ['book' => $libraryBook]);
    }

    public function update(Request $request, LibraryBook $libraryBook)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255', 'unique:library_books,isbn,' . $libraryBook->id],
            'publisher' => ['nullable', 'string', 'max:255'],
            'copies_total' => ['required', 'integer', 'min:0'],
            'shelf' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($data['copies_total'] < $libraryBook->copies_total) {
            $diff = $libraryBook->copies_total - $data['copies_total'];
            $available = max(0, $libraryBook->copies_available - $diff);
            $data['copies_available'] = $available;
        } elseif ($data['copies_total'] > $libraryBook->copies_total) {
            $diff = $data['copies_total'] - $libraryBook->copies_total;
            $data['copies_available'] = $libraryBook->copies_available + $diff;
        }

        $libraryBook->update($data);
        return redirect()->route('library.books.index')->with('success', 'Book updated.');
    }

    public function destroy(LibraryBook $libraryBook)
    {
        $libraryBook->delete();
        return redirect()->route('library.books.index')->with('success', 'Book deleted.');
    }
}

