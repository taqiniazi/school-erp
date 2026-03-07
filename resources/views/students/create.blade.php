@extends('layouts.bootstrap')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">Add New Student</div>
            <div class="card-body">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 class="mb-3">Personal Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name *</label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name *</label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="dob" class="form-label">Date of Birth *</label>
                            <input type="date" class="form-control" name="dob" value="{{ old('dob') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender *</label>
                            <select class="form-select" name="gender" required>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" name="photo">
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Academic Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="admission_number" class="form-label">Admission Number *</label>
                            <input type="text" class="form-control" name="admission_number" value="{{ old('admission_number') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="admission_date" class="form-label">Admission Date *</label>
                            <input type="date" class="form-control" name="admission_date" value="{{ old('admission_date') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="roll_number" class="form-label">Roll Number</label>
                            <input type="text" class="form-control" name="roll_number" value="{{ old('roll_number') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="campus_id" class="form-label">Campus</label>
                            <select class="form-select" name="campus_id">
                                <option value="">Select Campus</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="school_class_id" class="form-label">Class *</label>
                            <select class="form-select" name="school_class_id" id="school_class_id" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="section_id" class="form-label">Section *</label>
                            <select class="form-select" name="section_id" id="section_id" required disabled>
                                <option value="">Select Class First</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Contact Information</h5>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address *</label>
                        <textarea class="form-control" name="address" rows="2" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Parent Linkage (Optional)</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="parent_id" class="form-label">Select Parent</label>
                            <select class="form-select" name="parent_id">
                                <option value="">None</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }} ({{ $parent->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="relation" class="form-label">Relation</label>
                            <select class="form-select" name="relation">
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Guardian">Guardian</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Admit Student</button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const classSelect = document.getElementById('school_class_id');
    const sectionSelect = document.getElementById('section_id');
    const oldSectionId = "{{ old('section_id') }}";

    function loadSections(classId, selectedId = null) {
        sectionSelect.innerHTML = '<option value="">Loading...</option>';
        sectionSelect.disabled = true;
        
        fetch(`/classes/${classId}/sections`)
            .then(response => response.json())
            .then(data => {
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                data.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    if (selectedId && section.id == selectedId) {
                        option.selected = true;
                    }
                    sectionSelect.appendChild(option);
                });
                sectionSelect.disabled = false;
            });
    }

    classSelect.addEventListener('change', function() {
        if (this.value) {
            loadSections(this.value);
        } else {
            sectionSelect.innerHTML = '<option value="">Select Class First</option>';
            sectionSelect.disabled = true;
        }
    });

    if (classSelect.value) {
        loadSections(classSelect.value, oldSectionId);
    }
</script>
@endpush
@endsection
