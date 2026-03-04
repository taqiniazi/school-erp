@extends('layouts.bootstrap')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Teacher Details</h1>
    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
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
        <div class="card mb-4">
            <div class="card-header">Profile Information</div>
            <div class="card-body">
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

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Subject & Class Allocations</span>
            </div>
            <div class="card-body">
                <form action="{{ route('teachers.allocations.store', $teacher) }}" method="POST" class="row g-3 mb-4">
                    @csrf
                    <div class="col-md-4">
                        <select name="subject_id" class="form-select" required disabled>
                            <option value="">Select Class First</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="school_class_id" id="school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="section_id" id="section_id" class="form-select" required disabled>
                            <option value="">Select Class First</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Assign</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teacher->allocations as $allocation)
                            <tr>
                                <td>{{ $allocation->subject->name }} ({{ $allocation->subject->code }})</td>
                                <td>{{ $allocation->schoolClass->name }}</td>
                                <td>{{ $allocation->section->name }}</td>
                                <td>
                                    <form action="{{ route('teachers.allocations.destroy', $allocation) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this assignment?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No subjects assigned yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
@endsection
