﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Teacher Details</h1>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4 text-center">
                @if($teacher->photo_path)
                    <img src="{{ asset('storage/' . $teacher->photo_path) }}" alt="Photo" class="rounded-circle mb-3 object-fit-cover" width="150" height="150">
                @else
                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px; font-size: 3rem;">
                        {{ substr($teacher->user->name, 0, 1) }}
                    </div>
                @endif
                <h4>{{ $teacher->user->name }}</h4>
                <p class="text-muted">{{ $teacher->qualification }}</p>
                <span class="badge bg-{{ $teacher->status === 'active' ? 'success' : ($teacher->status === 'inactive' ? 'warning' : 'danger') }}">
                    {{ ucfirst($teacher->status) }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">Profile Information</div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Email</div>
                    <div class="col-sm-9">{{ $teacher->user->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Joining Date</div>
                    <div class="col-sm-9">{{ $teacher->joining_date }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Salary Grade</div>
                    <div class="col-sm-9">
                        @if($teacher->salaryStructure)
                            {{ $teacher->salaryStructure->grade }} ({{ number_format($teacher->salaryStructure->basic_salary, 2) }})
                        @else
                            Not Assigned
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Phone</div>
                    <div class="col-sm-9">{{ $teacher->phone ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Emergency Contact</div>
                    <div class="col-sm-9">{{ $teacher->emergency_contact ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Address</div>
                    <div class="col-sm-9">{{ $teacher->address }}</div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <span class="fw-semibold">Subject & Class Allocations</span>
            </div>
            <div class="card-body p-4">
                    <form action="{{ route('teachers.allocations.store', $teacher) }}" method="POST" class="row g-3 mb-4">
                        @csrf
                        <div class="col-md-3">
                            <label class="form-label small fw-medium">Class</label>
                            <select name="school_class_id" id="school_class_id" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-medium">Section</label>
                            <select name="section_id" id="section_id" class="form-select" required disabled>
                                <option value="">Select Class First</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">Subject</label>
                            <select name="subject_id" class="form-select" required disabled>
                                <option value="">Select Class First</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Assign</button>
                        </div>
                    </form>

                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teacher->allocations as $allocation)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $allocation->subject->name }} ({{ $allocation->subject->code }})</td>
                                <td class="p-3 text-nowrap">{{ $allocation->schoolClass->name }}</td>
                                <td class="p-3 text-nowrap">{{ $allocation->section->name }}</td>
                                <td class="p-3 text-nowrap text-end">
                                    <form action="{{ route('teachers.allocations.destroy', $allocation) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this assignment?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-secondary">No subjects assigned yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

@push('scripts')
<script>
    document.getElementById('school_class_id').addEventListener('change', function() {
        var classId = this.value;
        var sectionSelect = document.getElementById('section_id');
        var subjectSelect = document.querySelector('select[name="subject_id"]');
        
        sectionSelect.innerHTML = '<option value="">Loading...</option>';
        subjectSelect.innerHTML = '<option value="">Loading...</option>';
        sectionSelect.disabled = true;
        subjectSelect.disabled = true;
        
        if(classId) {
            // Load sections
            fetch(`/classes/${classId}/sections`)
                .then(response => response.json())
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    data.forEach(section => {
                        var option = document.createElement('option');
                        option.value = section.id;
                        option.text = section.name;
                        sectionSelect.appendChild(option);
                    });
                    sectionSelect.disabled = false;
                });
            
            // Load class-specific subjects
            fetch(`/classes/${classId}/subjects`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    data.forEach(subject => {
                        var option = document.createElement('option');
                        option.value = subject.id;
                        option.text = subject.name + ' (' + subject.code + ')';
                        subjectSelect.appendChild(option);
                    });
                    subjectSelect.disabled = false;
                });
        } else {
            sectionSelect.innerHTML = '<option value="">Select Class First</option>';
            subjectSelect.innerHTML = '<option value="">Select Class First</option>';
            sectionSelect.disabled = true;
            subjectSelect.disabled = true;
        }
    });
</script>
@endpush
</x-app-layout>

