@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Add Teacher</h1>
    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @php
                $teachersOld = old('teachers');
                if (!is_array($teachersOld) || count($teachersOld) === 0) {
                    $teachersOld = [[
                        'name' => old('name'),
                        'email' => old('email'),
                        'qualification' => old('qualification'),
                        'joining_date' => old('joining_date'),
                        'address' => old('address'),
                        'phone' => old('phone'),
                        'emergency_contact' => old('emergency_contact'),
                        'salary_structure_id' => old('salary_structure_id'),
                        'campus_id' => old('campus_id'),
                    ]];
                }
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold">Teachers</div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add_teacher_row">
                    <i class="fas fa-plus"></i> Add More
                </button>
            </div>

            <div id="teachers_container">
                @foreach($teachersOld as $index => $row)
                    <div class="teacher-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][name]" value="{{ data_get($row, 'name') }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="teachers[{{ $index }}][email]" value="{{ data_get($row, 'email') }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Qualification</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][qualification]" value="{{ data_get($row, 'qualification') }}" required>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="teachers[{{ $index }}][password]" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="teachers[{{ $index }}][password_confirmation]" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Joining Date</label>
                                <input type="date" class="form-control" name="teachers[{{ $index }}][joining_date]" value="{{ data_get($row, 'joining_date') }}" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Campus</label>
                                <select class="form-select" name="teachers[{{ $index }}][campus_id]">
                                    <option value="">Select Campus</option>
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus->id }}" {{ (string) data_get($row, 'campus_id') === (string) $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label">Salary Structure</label>
                                <select class="form-select" name="teachers[{{ $index }}][salary_structure_id]">
                                    <option value="">Select Salary Structure</option>
                                    @foreach($salaryStructures as $structure)
                                        <option value="{{ $structure->id }}" {{ (string) data_get($row, 'salary_structure_id') === (string) $structure->id ? 'selected' : '' }}>
                                            {{ $structure->grade }} - {{ number_format($structure->basic_salary, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][phone]" value="{{ data_get($row, 'phone') }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][emergency_contact]" value="{{ data_get($row, 'emergency_contact') }}">
                            </div>

                            <div class="col-12 col-md-8">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="teachers[{{ $index }}][address]" rows="2" required>{{ data_get($row, 'address') }}</textarea>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="teachers[{{ $index }}][photo]">
                            </div>
                            <div class="col-12 col-md-1 text-md-end">
                                <button type="button" class="btn btn-outline-danger w-100 remove-teacher-row">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Create Teachers</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('teachers_container');
        const addBtn = document.getElementById('add_teacher_row');

        function renumberRows() {
            const rows = container.querySelectorAll('.teacher-item');
            rows.forEach((row, idx) => {
                row.querySelectorAll('[name]').forEach((el) => {
                    el.name = el.name.replace(/teachers\[\d+\]/, `teachers[${idx}]`);
                });
            });
        }

        function addRow() {
            const idx = container.querySelectorAll('.teacher-item').length;
            const div = document.createElement('div');
            div.className = 'teacher-item border rounded p-3 mb-3';
            div.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="teachers[${idx}][name]" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="teachers[${idx}][email]" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="teachers[${idx}][qualification]" required>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="teachers[${idx}][password]" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="teachers[${idx}][password_confirmation]" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Joining Date</label>
                        <input type="date" class="form-control" name="teachers[${idx}][joining_date]" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Campus</label>
                        <select class="form-select" name="teachers[${idx}][campus_id]">
                            <option value="">Select Campus</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label">Salary Structure</label>
                        <select class="form-select" name="teachers[${idx}][salary_structure_id]">
                            <option value="">Select Salary Structure</option>
                            @foreach($salaryStructures as $structure)
                                <option value="{{ $structure->id }}">{{ $structure->grade }} - {{ number_format($structure->basic_salary, 2) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="teachers[${idx}][phone]">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control" name="teachers[${idx}][emergency_contact]">
                    </div>

                    <div class="col-12 col-md-8">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="teachers[${idx}][address]" rows="2" required></textarea>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Photo</label>
                        <input type="file" class="form-control" name="teachers[${idx}][photo]">
                    </div>
                    <div class="col-12 col-md-1 text-md-end">
                        <button type="button" class="btn btn-outline-danger w-100 remove-teacher-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        addBtn.addEventListener('click', addRow);

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-teacher-row');
            if (!btn) return;

            const row = btn.closest('.teacher-item');
            const rows = container.querySelectorAll('.teacher-item');

            if (rows.length <= 1) {
                row.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], textarea').forEach((el) => (el.value = ''));
                row.querySelectorAll('input[type="password"]').forEach((el) => (el.value = ''));
                row.querySelectorAll('input[type="file"]').forEach((el) => (el.value = ''));
                row.querySelectorAll('select').forEach((el) => (el.selectedIndex = 0));
                return;
            }

            row.remove();
            renumberRows();
        });
    });
</script>
@endpush
@endsection


