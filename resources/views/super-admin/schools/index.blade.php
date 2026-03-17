<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Schools</h1>
            <a href="{{ route('super-admin.schools.create') }}" class="btn btn-primary">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add School
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0 align-middle" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Admin</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Students</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teachers</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Campuses</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subscription</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                            <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $s)
                            @php
                                $sub = $s->subscriptions->first();
                            @endphp
                            <tr>
                                <td class="p-3 text-nowrap">{{ $s->name }}</td>
                                <td class="p-3 text-nowrap">
                                    @if($s->admin)
                                        {{ $s->admin->name }} ({{ $s->admin->email }})
                                    @else
                                        No Admin
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap">{{ $s->students_count }}</td>
                                <td class="p-3 text-nowrap">{{ $s->teachers_count }}</td>
                                <td class="p-3 text-nowrap">{{ $s->campus_count ?? $s->campuses_count }}</td>
                                <td class="p-3 text-nowrap">
                                    {{ optional(optional($sub)->plan)->name ?: '—' }}
                                    {{ $sub ? '(' . ucfirst($sub->status) . ')' : '' }}
                                </td>
                                <td class="p-3 text-nowrap">
                                    @if($s->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    @if(!$s->is_active)
                                        <form action="{{ route('super-admin.schools.activate', $s) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Activate</button>
                                        </form>
                                    @else
                                        <form action="{{ route('super-admin.schools.deactivate', $s) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-secondary">Deactivate</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
