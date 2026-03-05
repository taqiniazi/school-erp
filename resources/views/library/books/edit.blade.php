<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('library.books.update', $book) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" value="{{ $book->title }}" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Author</label>
                            <input type="text" name="author" value="{{ $book->author }}" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">ISBN</label>
                            <input type="text" name="isbn" value="{{ $book->isbn }}" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Publisher</label>
                            <input type="text" name="publisher" value="{{ $book->publisher }}" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Copies</label>
                            <input type="number" name="copies_total" min="0" value="{{ $book->copies_total }}" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Shelf</label>
                            <input type="text" name="shelf" value="{{ $book->shelf }}" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="active" @if($book->status==='active') selected @endif>Active</option>
                                <option value="inactive" @if($book->status==='inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                            <a href="{{ route('library.books.index') }}" class="ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

