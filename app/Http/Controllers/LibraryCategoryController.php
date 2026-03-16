<?php

namespace App\Http\Controllers;

use App\Models\LibraryCategory;
use App\Services\SchoolContext;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LibraryCategoryController extends Controller
{
    public function index()
    {
        $categories = LibraryCategory::orderBy('name')->get();

        return view('library.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('library.categories.create');
    }

    public function store(Request $request)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('library_categories', 'name');
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        LibraryCategory::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('library.categories.index')->with('success', 'Category created.');
    }

    public function edit(LibraryCategory $category)
    {
        return view('library.categories.edit', compact('category'));
    }

    public function update(Request $request, LibraryCategory $category)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('library_categories', 'name')->ignore($category->id);
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('library.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(LibraryCategory $category)
    {
        $category->delete();

        return redirect()->route('library.categories.index')->with('success', 'Category deleted.');
    }
}
