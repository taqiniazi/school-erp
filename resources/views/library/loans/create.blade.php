<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold">Issue Book Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('library.loans.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Book</label>
                                <select name="library_book_id" class="form-select" required>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->copies_available }} available)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Borrower</label>
                                <select name="user_id" class="form-select" required>
                                    @foreach($borrowers as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Per Day Fine</label>
                                <input type="number" step="0.01" min="0" name="per_day_fine" value="5.00" class="form-control">
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('library.loans.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Issue Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

