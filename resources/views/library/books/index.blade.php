<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Library Books</h1>
            <a href="{{ route('library.books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New Book
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Title</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Author</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">ISBN</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Available</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Shelf</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td class="p-3 fw-semibold">{{ $book->title }}</td>
                                    <td class="p-3">{{ $book->author }}</td>
                                    <td class="p-3 text-nowrap">{{ $book->isbn }}</td>
                                    <td class="p-3 text-end text-nowrap">
                                        <span class="badge bg-info">{{ $book->copies_available }} / {{ $book->copies_total }}</span>
                                    </td>
                                    <td class="p-3 text-nowrap">{{ $book->shelf }}</td>
                                    <td class="p-3 text-nowrap">
                                        <span class="badge {{ $book->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-end text-nowrap">
                                        <a href="{{ route('library.books.edit', $book) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('library.books.destroy', $book) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this book?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                <div class="mt-4">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

