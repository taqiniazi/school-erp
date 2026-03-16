<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Library Categories</h1>
            <a href="{{ route('library.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New Category
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Description</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="p-3 fw-semibold text-nowrap">{{ $category->name }}</td>
                                    <td class="p-3">{{ $category->description ?? '-' }}</td>
                                    <td class="p-3 text-nowrap">
                                        @if ($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-end text-nowrap">
                                        <a href="{{ route('library.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('library.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-secondary">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
