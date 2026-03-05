<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library Books') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('library.books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">New Book</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ISBN</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Available</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shelf</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($books as $book)
                                    <tr>
                                        <td class="px-6 py-4">{{ $book->title }}</td>
                                        <td class="px-6 py-4">{{ $book->author }}</td>
                                        <td class="px-6 py-4">{{ $book->isbn }}</td>
                                        <td class="px-6 py-4 text-right">{{ $book->copies_available }} / {{ $book->copies_total }}</td>
                                        <td class="px-6 py-4">{{ $book->shelf }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($book->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('library.books.edit', $book) }}" class="text-blue-600">Edit</a>
                                            <form action="{{ route('library.books.destroy', $book) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 ml-3" onclick="return confirm('Delete this book?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

