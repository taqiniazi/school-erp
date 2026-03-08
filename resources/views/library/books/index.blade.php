<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">Library Books</h2>
            <a href="{{ route('library.books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New Book
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th class="text-end">Available</th>
                                <th>Shelf</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td class="fw-bold">{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-info">{{ $book->copies_available }} / {{ $book->copies_total }}</span>
                                    </td>
                                    <td>{{ $book->shelf }}</td>
                                    <td>
                                        <span class="badge {{ $book->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
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
            </div>
        </div>
    </div>
</x-app-layout>



