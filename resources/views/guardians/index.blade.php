<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Guardians</h1>
                <div class="text-muted">View parent/guardian accounts linked to students.</div>
            </div>
            <form method="GET" action="{{ route('guardians.index') }}" class="d-flex gap-2">
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control form-control-sm" placeholder="Search guardians...">
                <button type="submit" class="btn btn-sm btn-outline-secondary">Search</button>
            </form>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Email</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Students</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guardians as $guardian)
                                <tr>
                                    <td class="p-3 text-nowrap fw-semibold">{{ $guardian->name }}</td>
                                    <td class="p-3 text-nowrap">{{ $guardian->email }}</td>
                                    <td class="p-3 text-nowrap">{{ $guardian->phone_number }}</td>
                                    <td class="p-3 text-nowrap">
                                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-2">
                                            {{ $guardian->students_count }} linked
                                        </span>
                                    </td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('guardians.show', $guardian) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center text-secondary">No guardians found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
