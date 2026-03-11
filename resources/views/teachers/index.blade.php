﻿﻿﻿﻿﻿<x-app-layout>
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 text-gray-800 mb-1">Teachers</h1>
                <p class="text-muted small mb-0">Manage faculty members, assignments, and qualifications.</p>
            </div>
            <a href="{{ route('teachers.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i>Add New Teacher
            </a>
        </div>

        <!-- Main Content Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold"><i class="fas fa-chalkboard-teacher me-2"></i>Teacher List</h5>
                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search teachers..." aria-label="Search">
                    </div>
                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-filter me-1"></i> Filter</button>
                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-export me-1"></i> Export</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Teacher Name</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Contact Info</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Qualification</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Status</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        @if($teacher->photo_path)
                                            <img src="{{ asset('storage/' . $teacher->photo_path) }}" alt="Photo" class="rounded-circle object-fit-cover me-3 shadow-sm" width="40" height="40">
                                        @else
                                            <div class="avatar-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ substr($teacher->user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $teacher->user->name }}</div>
                                            <div class="small text-muted">ID: {{ $teacher->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex flex-column">
                                        <div class="text-dark small"><i class="fas fa-envelope text-muted me-2"></i>{{ $teacher->user->email }}</div>
                                        <div class="text-dark small"><i class="fas fa-phone text-muted me-2"></i>{{ $teacher->phone ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border border-light-subtle rounded-pill px-3 py-2">
                                        {{ $teacher->qualification }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match($teacher->status) {
                                            'active' => 'bg-success bg-opacity-10 text-success',
                                            'inactive' => 'bg-secondary bg-opacity-10 text-secondary',
                                            'on_leave' => 'bg-warning bg-opacity-10 text-warning',
                                            default => 'bg-secondary bg-opacity-10 text-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-2 py-1 rounded-2 fw-medium">
                                        {{ ucfirst($teacher->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                            <li><a class="dropdown-item" href="{{ route('teachers.show', $teacher) }}"><i class="fas fa-eye text-info me-2"></i> View Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('teachers.edit', $teacher) }}"><i class="fas fa-edit text-warning me-2"></i> Edit Teacher</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the user account too.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-chalkboard-teacher fa-3x opacity-25"></i>
                                    </div>
                                    <h6 class="text-secondary fw-bold">No teachers found</h6>
                                    <p class="text-muted small">Start by adding faculty members to the system.</p>
                                    <a href="{{ route('teachers.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Add Teacher
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($teachers->hasPages())
            <div class="card-footer bg-white py-3 border-top border-light">
                {{ $teachers->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
