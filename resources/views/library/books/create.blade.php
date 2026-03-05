<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Book') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('library.books.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Author</label>
                            <input type="text" name="author" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">ISBN</label>
                            <input type="text" name="isbn" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Publisher</label>
                            <input type="text" name="publisher" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Copies</label>
                            <input type="number" name="copies_total" min="0" value="0" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Shelf</label>
                            <input type="text" name="shelf" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
                            <a href="{{ route('library.books.index') }}" class="ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

