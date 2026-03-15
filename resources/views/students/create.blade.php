﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('Add New Student') }}</h1>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container px-4">
            <div class="card shadow-sm">
                <div class="card-body p-4 text-dark">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @php
                            $studentsOld = old('students');
                            if (!is_array($studentsOld) || count($studentsOld) === 0) {
                                $studentsOld = [[
                                    'first_name' => old('first_name'),
                                    'last_name' => old('last_name'),
                                    'admission_number' => old('admission_number'),
                                    'roll_number' => old('roll_number'),
                                    'dob' => old('dob'),
                                    'gender' => old('gender', 'male'),
                                    'school_class_id' => old('school_class_id'),
                                    'section_id' => old('section_id'),
                                    'campus_id' => old('campus_id'),
                                    'admission_date' => old('admission_date'),
                                    'address' => old('address'),
                                    'phone' => old('phone'),
                                    'email' => old('email'),
                                    'parent_id' => old('parent_id'),
                                    'relation' => old('relation'),
                                ]];
                            }
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-semibold">Students</div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add_student_row">
                                <i class="fas fa-plus"></i> Add More
                            </button>
                        </div>

                        <div id="students_container">
                            @foreach($studentsOld as $index => $row)
                                @php
                                    $classId = data_get($row, 'school_class_id');
                                    $sectionId = data_get($row, 'section_id');
                                @endphp
                                <div class="student-item border rounded p-3 mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="students[{{ $index }}][first_name]" class="form-control" value="{{ data_get($row, 'first_name') }}" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="students[{{ $index }}][last_name]" class="form-control" value="{{ data_get($row, 'last_name') }}" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Admission #</label>
                                            <input type="text" name="students[{{ $index }}][admission_number]" class="form-control" value="{{ data_get($row, 'admission_number') }}" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Roll #</label>
                                            <input type="text" name="students[{{ $index }}][roll_number]" class="form-control" value="{{ data_get($row, 'roll_number') }}">
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label class="form-label">DOB</label>
                                            <input type="date" name="students[{{ $index }}][dob]" class="form-control" value="{{ data_get($row, 'dob') }}" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Gender</label>
                                            <select name="students[{{ $index }}][gender]" class="form-select" required>
                                                <option value="male" {{ data_get($row, 'gender') === 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ data_get($row, 'gender') === 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ data_get($row, 'gender') === 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Campus</label>
                                            <select name="students[{{ $index }}][campus_id]" class="form-select">
                                                <option value="">Select Campus</option>
                                                @foreach($campuses as $campus)
                                                    <option value="{{ $campus->id }}" {{ (string) data_get($row, 'campus_id') === (string) $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Admission Date</label>
                                            <input type="date" name="students[{{ $index }}][admission_date]" class="form-control" value="{{ data_get($row, 'admission_date') }}" required>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Class</label>
                                            <select name="students[{{ $index }}][school_class_id]" class="form-select student-class" required>
                                                <option value="">Select Class</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ (string) $classId === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Section</label>
                                            <select name="students[{{ $index }}][section_id]" class="form-select student-section" data-selected="{{ $sectionId }}" {{ $classId ? '' : 'disabled' }}>
                                                <option value="">{{ $classId ? 'Loading...' : 'Select Class First' }}</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Parent</label>
                                            <select name="students[{{ $index }}][parent_id]" class="form-select">
                                                <option value="">Select Parent</option>
                                                @foreach($parents as $parent)
                                                    <option value="{{ $parent->id }}" {{ (string) data_get($row, 'parent_id') === (string) $parent->id ? 'selected' : '' }}>{{ $parent->name }} ({{ $parent->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Relation</label>
                                            <input type="text" name="students[{{ $index }}][relation]" class="form-control" value="{{ data_get($row, 'relation') }}" placeholder="Guardian">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="students[{{ $index }}][phone]" class="form-control" value="{{ data_get($row, 'phone') }}">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="students[{{ $index }}][email]" class="form-control" value="{{ data_get($row, 'email') }}">
                                        </div>

                                        <div class="col-12 col-md-8">
                                            <label class="form-label">Address</label>
                                            <textarea name="students[{{ $index }}][address]" rows="2" class="form-control" required>{{ data_get($row, 'address') }}</textarea>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Photo</label>
                                            <input type="file" name="students[{{ $index }}][photo]" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-1 text-md-end">
                                            <button type="button" class="btn btn-outline-danger w-100 remove-student-row">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('students.index') }}" class="me-3 btn btn-light border text-dark">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                Save Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('students_container');
            const addBtn = document.getElementById('add_student_row');

            async function loadSectionsForRow(row, classId, selectedSectionId = null) {
                const sectionSelect = row.querySelector('.student-section');
                if (!sectionSelect) return;

                sectionSelect.innerHTML = '<option value="">Loading...</option>';
                sectionSelect.disabled = true;

                if (!classId) {
                    sectionSelect.innerHTML = '<option value="">Select Class First</option>';
                    sectionSelect.disabled = true;
                    return;
                }

                try {
                    const response = await fetch(`/classes/${classId}/sections`);
                    const sections = await response.json();

                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    sections.forEach((section) => {
                        const option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.name;
                        if (selectedSectionId && String(section.id) === String(selectedSectionId)) {
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

            function renumberRows() {
                const rows = container.querySelectorAll('.student-item');
                rows.forEach((row, idx) => {
                    row.querySelectorAll('[name]').forEach((el) => {
                        el.name = el.name.replace(/students\[\d+\]/, `students[${idx}]`);
                    });
                });
            }

            function addRow() {
                const idx = container.querySelectorAll('.student-item').length;
                const div = document.createElement('div');
                div.className = 'student-item border rounded p-3 mb-3';
                div.innerHTML = `
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="students[${idx}][first_name]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="students[${idx}][last_name]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Admission #</label>
                            <input type="text" name="students[${idx}][admission_number]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Roll #</label>
                            <input type="text" name="students[${idx}][roll_number]" class="form-control">
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label">DOB</label>
                            <input type="date" name="students[${idx}][dob]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Gender</label>
                            <select name="students[${idx}][gender]" class="form-select" required>
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Campus</label>
                            <select name="students[${idx}][campus_id]" class="form-select">
                                <option value="">Select Campus</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Admission Date</label>
                            <input type="date" name="students[${idx}][admission_date]" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label">Class</label>
                            <select name="students[${idx}][school_class_id]" class="form-select student-class" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Section</label>
                            <select name="students[${idx}][section_id]" class="form-select student-section" data-selected="" disabled>
                                <option value="">Select Class First</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Parent</label>
                            <select name="students[${idx}][parent_id]" class="form-select">
                                <option value="">Select Parent</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }} ({{ $parent->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label">Relation</label>
                            <input type="text" name="students[${idx}][relation]" class="form-control" placeholder="Guardian">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="students[${idx}][phone]" class="form-control">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="students[${idx}][email]" class="form-control">
                        </div>

                        <div class="col-12 col-md-8">
                            <label class="form-label">Address</label>
                            <textarea name="students[${idx}][address]" rows="2" class="form-control" required></textarea>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="students[${idx}][photo]" class="form-control">
                        </div>
                        <div class="col-12 col-md-1 text-md-end">
                            <button type="button" class="btn btn-outline-danger w-100 remove-student-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            }

            addBtn.addEventListener('click', addRow);

            container.addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-student-row');
                if (!btn) return;

                const row = btn.closest('.student-item');
                const rows = container.querySelectorAll('.student-item');

                if (rows.length <= 1) {
                    row.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], textarea').forEach((el) => (el.value = ''));
                    row.querySelectorAll('select').forEach((el) => {
                        if (el.classList.contains('student-section')) {
                            el.innerHTML = '<option value="">Select Class First</option>';
                            el.disabled = true;
                            return;
                        }
                        el.selectedIndex = 0;
                    });
                    const genderSelect = row.querySelector('select[name*="[gender]"]');
                    if (genderSelect) genderSelect.value = 'male';
                    row.querySelectorAll('input[type="file"]').forEach((el) => (el.value = ''));
                    return;
                }

                row.remove();
                renumberRows();
            });

            container.addEventListener('change', function (e) {
                const classSelect = e.target.closest('.student-class');
                if (!classSelect) return;
                const row = classSelect.closest('.student-item');
                if (!row) return;
                loadSectionsForRow(row, classSelect.value);
            });

            document.querySelectorAll('.student-item').forEach((row) => {
                const classSelect = row.querySelector('.student-class');
                const sectionSelect = row.querySelector('.student-section');
                const classId = classSelect ? classSelect.value : null;
                const selectedSection = sectionSelect ? sectionSelect.getAttribute('data-selected') : null;
                if (classId) {
                    loadSectionsForRow(row, classId, selectedSection);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>

