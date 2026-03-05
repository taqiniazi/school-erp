<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Issue Book') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('library.loans.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Book</label>
                            <select name="library_book_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->copies_available }} available)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Borrower</label>
                            <select name="user_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                                @foreach($borrowers as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Per Day Fine</label>
                            <input type="number" step="0.01" min="0" name="per_day_fine" value="5.00" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Issue</button>
                            <a href="{{ route('library.loans.index') }}" class="ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

