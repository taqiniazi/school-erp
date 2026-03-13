<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('Staff Profiles') }}</h1>
            <a href="{{ route('hr.staff.create') }}" class="btn btn-primary">New Profile</a>
        </div>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Designation</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Department</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($profiles as $p)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $p->teacher->first_name }} {{ $p->teacher->last_name }}</td>
                                        <td class="p-3 text-nowrap">{{ $p->designation ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">{{ $p->department ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">{{ $p->phone ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">
                                            <span class="badge rounded-pill {{ $p->status === 'active' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('hr.staff.edit', $p) }}" class="btn btn-sm btn-success text-decoration-none">Edit</a>
                                            <form action="{{ route('hr.staff.destroy', $p) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-link text-danger text-decoration-none" onclick="return confirm('Delete profile?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="p-3 text-center text-secondary">No staff profiles</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




