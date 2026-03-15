<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Permissions</h1>
            @role('Super Admin')
                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add Permission</a>
            @endrole
        </div>
    </x-slot>

    <div class="container-fluid py-4">
     

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-end" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td class="text-end">
                                        @role('Super Admin')
                                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this permission?')">Delete</button>
                                            </form>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-2">No actions</span>
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">No permissions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
