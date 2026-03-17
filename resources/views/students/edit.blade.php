﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark  lh-sm">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container px-4">
            <div class="card shadow-sm">
                <div class="card-body p-4 text-dark">
                    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h3 class="lead fw-medium text-dark mb-4 border-bottom pb-2">Personal Information</h3>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label small fw-medium text-dark">First Name *</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" required class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label small fw-medium text-dark">Last Name *</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" required class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="dob" class="form-label small fw-medium text-dark">Date of Birth *</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob', $student->dob) }}" required class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="gender" class="form-label small fw-medium text-dark">Gender *</label>
                                    <select name="gender" id="gender" required class="form-select">
                                        <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="photo" class="form-label small fw-medium text-dark">Photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    @if($student->photo_path)
                                        <p class="mt-2 small text-secondary">Current photo exists</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="mb-4">
                            <h3 class="lead fw-medium text-dark mb-4 border-bottom pb-2">Academic Information</h3>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label for="admission_number" class="form-label small fw-medium text-dark">Admission Number</label>
                                    <input type="text" name="admission_number" id="admission_number" value="{{ old('admission_number', $student->admission_number) }}" readonly class="form-control bg-light">
                                </div>
                                <div class="col-md-4">
                                    <label for="roll_number" class="form-label small fw-medium text-dark">Roll Number</label>
                                    <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number', $student->roll_number) }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label small fw-medium text-dark">Status *</label>
                                    <select name="status" id="status" required class="form-select">
                                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                        <option value="left" {{ old('status', $student->status) == 'left' ? 'selected' : '' }}>Left</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="campus_id" class="form-label small fw-medium text-dark">Campus</label>
                                    <select name="campus_id" id="campus_id" class="form-select">
                                        <option value="">Select Campus</option>
                                        @foreach($campuses as $campus)
                                            <option value="{{ $campus->id }}" {{ old('campus_id', $student->campus_id) == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="school_class_id" class="form-label small fw-medium text-dark">Class *</label>
                                    <select name="school_class_id" id="school_class_id" required class="form-select">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="section_id" class="form-label small fw-medium text-dark">Section *</label>
                                    <select name="section_id" id="section_id" required class="form-select">
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h3 class="lead fw-medium text-dark mb-4 border-bottom pb-2">Contact Information</h3>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="address" class="form-label small fw-medium text-dark">Address *</label>
                                    <textarea name="address" id="address" rows="2" required class="form-control">{{ old('address', $student->address) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label small fw-medium text-dark">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-medium text-dark">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('students.index') }}" class="btn btn-light border text-dark">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                Update Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const classSelect = document.getElementById('school_class_id');
        const sectionSelect = document.getElementById('section_id');
        const initialClassId = "{{ $student->school_class_id }}";
        const oldSectionId = "{{ old('section_id', $student->section_id) }}";

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

        // Check if the current class (old or selected) is different from the initial class
        // If different, it means we have a validation error with a changed class, so we must reload sections
        // If same, the server-rendered sections are correct
        if (classSelect.value && classSelect.value != initialClassId) {
            loadSections(classSelect.value, oldSectionId);
        }
    </script>
</x-app-layout>




