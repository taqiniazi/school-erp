<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Admissions</h1>
                <div class="text-muted">Admit new students and review recent admissions</div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Admit Students
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-users me-2"></i>All Students
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid px-4 py-4">
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Total Students</div>
                                <div class="kpi-value">{{ number_format((int) ($kpis['total_students'] ?? 0)) }}</div>
                                <div class="kpi-meta">All enrolled students</div>
                            </div>
                            <div class="kpi-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Active Students</div>
                                <div class="kpi-value">{{ number_format((int) ($kpis['active_students'] ?? 0)) }}</div>
                                <div class="kpi-meta">Currently active</div>
                            </div>
                            <div class="kpi-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Admitted Today</div>
                                <div class="kpi-value">{{ number_format((int) ($kpis['admitted_today'] ?? 0)) }}</div>
                                <div class="kpi-meta">{{ now()->format('M d, Y') }}</div>
                            </div>
                            <div class="kpi-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Admitted This Month</div>
                                <div class="kpi-value">{{ number_format((int) ($kpis['admitted_this_month'] ?? 0)) }}</div>
                                <div class="kpi-meta">{{ now()->format('F Y') }}</div>
                            </div>
                            <div class="kpi-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('admissions.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="q" class="form-control border-0 bg-light" value="{{ $q ?? '' }}" placeholder="Name, admission #, email, phone">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Class</label>
                            <select name="school_class_id" id="filterClass" class="form-select">
                                <option value="">All</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ (string) ($schoolClassId ?? '') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Section</label>
                            <select name="section_id" id="filterSection" class="form-select" {{ empty($schoolClassId) ? 'disabled' : '' }}>
                                <option value="">{{ empty($schoolClassId) ? 'Select class first' : 'All' }}</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ (string) ($sectionId ?? '') === (string) $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="graduated" {{ ($status ?? '') === 'graduated' ? 'selected' : '' }}>Graduated</option>
                                <option value="left" {{ ($status ?? '') === 'left' ? 'selected' : '' }}>Left</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-1">
                            <label class="form-label">From</label>
                            <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
                        </div>

                        <div class="col-12 col-md-6 col-lg-1">
                            <label class="form-label">To</label>
                            <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
                        </div>

                        <div class="col-12 d-flex gap-2 justify-content-end">
                            <a href="{{ route('admissions.index') }}" class="btn btn-light border">Reset</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <div class="fw-bold">Recent Admissions</div>
                    <div class="text-muted small">{{ $admissions->count() }} record(s)</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('students.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>New Admission
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 no-datatable">
                        <thead>
                            <tr>
                                <th>Admission Date</th>
                                <th>Admission #</th>
                                <th>Student</th>
                                <th>Class & Section</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admissions as $student)
                                @php
                                    $statusClass = match($student->status) {
                                        'active' => 'bg-success bg-opacity-10 text-success',
                                        'graduated' => 'bg-info bg-opacity-10 text-info',
                                        'left' => 'bg-secondary bg-opacity-10 text-secondary',
                                        default => 'bg-secondary bg-opacity-10 text-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('M d, Y') : 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium font-monospace text-dark">{{ $student->admission_number }}</span>
                                    </td>
                                    <td>
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
                                    <td>
                                        <span class="badge bg-light text-dark border border-light-subtle rounded-pill px-3 py-2">
                                            {{ $student->schoolClass?->name ?? 'N/A' }} - {{ $student->section?->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $statusClass }} px-2 py-1 rounded-2 fw-medium">{{ ucfirst($student->status) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('students.show', $student) }}">
                                                        <i class="fas fa-eye text-info me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('students.edit', $student) }}">
                                                        <i class="fas fa-edit text-warning me-2"></i>Edit Student
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i class="fas fa-user-plus fa-3x opacity-25"></i>
                                        </div>
                                        <h6 class="text-secondary fw-bold">No admissions found</h6>
                                        <p class="text-muted small mb-0">Try adjusting your filters, or admit a new student.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const classSelect = document.getElementById('filterClass');
                const sectionSelect = document.getElementById('filterSection');
                if (!classSelect || !sectionSelect) return;

                async function loadSections(classId) {
                    sectionSelect.innerHTML = '<option value="">Loading...</option>';
                    sectionSelect.disabled = true;

                    if (!classId) {
                        sectionSelect.innerHTML = '<option value="">Select class first</option>';
                        sectionSelect.disabled = true;
                        return;
                    }

                    try {
                        const response = await fetch(`/classes/${classId}/sections`);
                        const sections = await response.json();
                        const selectedId = @json($sectionId ?? '');

                        sectionSelect.innerHTML = '<option value="">All</option>';
                        sections.forEach((s) => {
                            const option = document.createElement('option');
                            option.value = s.id;
                            option.textContent = s.name;
                            if (selectedId && String(selectedId) === String(s.id)) {
                                option.selected = true;
                            }
                            sectionSelect.appendChild(option);
                        });
                        sectionSelect.disabled = false;
                    } catch (e) {
                        sectionSelect.innerHTML = '<option value="">Failed to load</option>';
                        sectionSelect.disabled = true;
                    }
                }

                classSelect.addEventListener('change', function () {
                    loadSections(classSelect.value);
                });
            });
        </script>
    @endpush
</x-app-layout>
