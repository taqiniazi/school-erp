<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold">Edit Category</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('library.categories.update', $category) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('library.categories.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

