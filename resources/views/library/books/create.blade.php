<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">New Book Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('library.books.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" name="author" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ISBN</label>
                                <input type="text" name="isbn" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Publisher</label>
                                <input type="text" name="publisher" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Copies</label>
                                <input type="number" name="copies_total" min="0" value="0" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Shelf</label>
                                <input type="text" name="shelf" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('library.books.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

