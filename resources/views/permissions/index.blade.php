<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">
            Permissions
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form class="d-flex gap-2" method="GET" action="{{ route('permissions.index') }}">
                <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search permissions...">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </form>

            @role('Super Admin')
                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add Permission</a>
            @endrole
        </div>

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
                                            <span class="text-muted">No actions</span>
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

        <div class="mt-3">
            {{ $permissions->links() }}
        </div>
    </div>
</x-app-layout>
