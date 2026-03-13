<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Designations</h1>
            <a href="{{ route('designations.create') }}" class="btn btn-primary">Add Designation</a>
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
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($designations as $designation)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $designation->name }}</td>
                                    <td class="p-3">{{ $designation->description }}</td>
                                    <td class="p-3 text-nowrap">
                                        @if ($designation->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('designations.edit', $designation) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('designations.destroy', $designation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this designation?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-secondary">No designations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $designations->links() }}
        </div>
    </div>
</x-app-layout>
