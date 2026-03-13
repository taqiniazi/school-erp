<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Students</h1>
                <div class="text-muted">Manage student records, admissions, and academic progress.</div>
            </div>
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Student
            </a>
        </div>
    </x-slot>

    <div class="container-fluid px-4 py-4">
        <!-- Main Content Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold"><i class="fas fa-user-graduate me-2"></i>Student List</h5>
                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search students..." aria-label="Search">
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
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Admission No</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Student Name</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Class & Section</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Parent / Guardian</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Status</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="fw-medium font-monospace text-dark">{{ $student->admission_number }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            {{ substr($student->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $student->first_name }} {{ $student->last_name }}</div>
                                            <div class="small text-muted">{{ $student->email ?? 'No email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border border-light-subtle rounded-pill px-3 py-2">
                                        {{ $student->schoolClass->name }} - {{ $student->section->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @foreach($student->parents as $parent)
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-medium">{{ $parent->name }}</span>
                                            <span class="small text-muted">{{ $parent->pivot->relation }}</span>
                                        </div>
                                    @endforeach
                                    @if($student->parents->isEmpty())
                                        <span class="text-muted small fst-italic">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match($student->status) {
                                            'active' => 'bg-success bg-opacity-10 text-success',
                                            'graduated' => 'bg-info bg-opacity-10 text-info',
                                            'suspended' => 'bg-warning bg-opacity-10 text-warning',
                                            'inactive' => 'bg-secondary bg-opacity-10 text-secondary',
                                            default => 'bg-secondary bg-opacity-10 text-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-2 py-1 rounded-2 fw-medium">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                            <li><a class="dropdown-item" href="{{ route('students.show', $student) }}"><i class="fas fa-eye text-info me-2"></i> View Details</a></li>
                                            <li><a class="dropdown-item" href="{{ route('students.edit', $student) }}"><i class="fas fa-edit text-warning me-2"></i> Edit Student</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-user-graduate fa-3x opacity-25"></i>
                                    </div>
                                    <h6 class="text-secondary fw-bold">No students found</h6>
                                    <p class="text-muted small">Get started by adding a new student to the system.</p>
                                    <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Add Student
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($students->hasPages())
            <div class="card-footer bg-white py-3 border-top border-light">
                {{ $students->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
