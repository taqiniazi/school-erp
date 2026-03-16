<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Exam Types</h1>
            <a href="{{ route('exam-types.create') }}" class="btn btn-primary">New Exam Type</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Description</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examTypes as $type)
                                <tr>
                                    <td class="p-3 text-nowrap fw-semibold">{{ $type->name }}</td>
                                    <td class="p-3">{{ $type->description ?? '-' }}</td>
                                    <td class="p-3 text-nowrap">
                                        @if ($type->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('exam-types.edit', $type) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('exam-types.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-secondary">No exam types found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
