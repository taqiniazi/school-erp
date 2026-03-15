<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Sections</h1>
                <div class="text-muted">Manage sections across classes.</div>
            </div>
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

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('sections.manage.store') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-12 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. A" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Class</label>
                        <select name="school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ (string) old('school_class_id') === (string) $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Campus (optional)</label>
                        <select name="campus_id" class="form-select">
                            <option value="">All Campuses</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}" {{ (string) old('campus_id') === (string) $campus->id ? 'selected' : '' }}>
                                    {{ $campus->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Campus</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                                <tr>
                                    <td class="p-3 text-nowrap fw-semibold">{{ $section->name }}</td>
                                    <td class="p-3 text-nowrap">{{ $section->schoolClass->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">{{ $section->campus->name ?? 'All' }}</td>
                                    <td class="p-3 text-nowrap text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editSectionModal"
                                            data-section-id="{{ $section->id }}"
                                            data-section-name="{{ $section->name }}"
                                            data-school-class-id="{{ $section->school_class_id }}"
                                            data-campus-id="{{ $section->campus_id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('sections.manage.destroy', $section) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this section?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-secondary">No sections found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="editSectionForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="editSectionName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Class</label>
                            <select name="school_class_id" id="editSchoolClassId" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Campus (optional)</label>
                            <select name="campus_id" id="editCampusId" class="form-select">
                                <option value="">All Campuses</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('editSectionModal');
                const form = document.getElementById('editSectionForm');
                const nameInput = document.getElementById('editSectionName');
                const classSelect = document.getElementById('editSchoolClassId');
                const campusSelect = document.getElementById('editCampusId');

                modal.addEventListener('show.bs.modal', function (e) {
                    const btn = e.relatedTarget;
                    if (!btn) return;
                    const id = btn.getAttribute('data-section-id');
                    const name = btn.getAttribute('data-section-name');
                    const classId = btn.getAttribute('data-school-class-id');
                    const campusId = btn.getAttribute('data-campus-id');

                    form.action = `/sections/manage/${id}`;
                    nameInput.value = name || '';
                    classSelect.value = classId || '';
                    campusSelect.value = campusId || '';
                });
            });
        </script>
    @endpush
</x-app-layout>
