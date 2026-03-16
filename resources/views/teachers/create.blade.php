<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Add Teacher</h1>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
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
                        'basic_salary' => old('basic_salary'),
                        'mobile_allowance' => old('mobile_allowance'),
                        'petrol_allowance' => old('petrol_allowance'),
                        'pf' => old('pf'),
                        'custom_deduction_name' => old('custom_deduction_name'),
                        'custom_deduction_is_percentage' => old('custom_deduction_is_percentage'),
                        'custom_deduction_amount' => old('custom_deduction_amount'),
                        'address' => old('address'),
                        'phone' => old('phone'),
                        'emergency_contact' => old('emergency_contact'),
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
                                <label class="form-label">Basic Salary</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="teachers[{{ $index }}][basic_salary]" value="{{ data_get($row, 'basic_salary') }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][phone]" value="{{ data_get($row, 'phone') }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][emergency_contact]" value="{{ data_get($row, 'emergency_contact') }}">
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="teachers[{{ $index }}][address]" rows="2" required>{{ data_get($row, 'address') }}</textarea>
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label d-block">Allowances / PF</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <label class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="teachers[{{ $index }}][mobile_allowance]" value="1" {{ data_get($row, 'mobile_allowance') ? 'checked' : '' }}>
                                        <span class="form-check-label">Mobile Allowance (1500)</span>
                                    </label>
                                    <label class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="teachers[{{ $index }}][petrol_allowance]" value="1" {{ data_get($row, 'petrol_allowance') ? 'checked' : '' }}>
                                        <span class="form-check-label">Petrol Allowance (10000)</span>
                                    </label>
                                    <label class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="teachers[{{ $index }}][pf]" value="1" {{ data_get($row, 'pf') ? 'checked' : '' }}>
                                        <span class="form-check-label">PF (8% of Basic)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Custom Deduction Name</label>
                                <input type="text" class="form-control" name="teachers[{{ $index }}][custom_deduction_name]" value="{{ data_get($row, 'custom_deduction_name') }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Custom Deduction Amount / %</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="teachers[{{ $index }}][custom_deduction_amount]" value="{{ data_get($row, 'custom_deduction_amount') }}">
                            </div>
                            <div class="col-12 col-md-3 d-flex align-items-end">
                                <label class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="teachers[{{ $index }}][custom_deduction_is_percentage]" value="1" {{ data_get($row, 'custom_deduction_is_percentage') ? 'checked' : '' }}>
                                    <span class="form-check-label">Percentage</span>
                                </label>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="teachers[{{ $index }}][photo]" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Last Degree Certificate</label>
                                <input type="file" class="form-control" name="teachers[{{ $index }}][last_degree_certificate]" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">CNIC Front</label>
                                <input type="file" class="form-control" name="teachers[{{ $index }}][cnic_front]" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">CNIC Back</label>
                                <input type="file" class="form-control" name="teachers[{{ $index }}][cnic_back]" required>
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
    </div>
</x-app-layout>

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
                        <label class="form-label">Basic Salary</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="teachers[${idx}][basic_salary]" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="teachers[${idx}][phone]">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control" name="teachers[${idx}][emergency_contact]">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="teachers[${idx}][address]" rows="2" required></textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label d-block">Allowances / PF</label>
                        <div class="d-flex flex-wrap gap-3">
                            <label class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="teachers[${idx}][mobile_allowance]" value="1">
                                <span class="form-check-label">Mobile Allowance (1500)</span>
                            </label>
                            <label class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="teachers[${idx}][petrol_allowance]" value="1">
                                <span class="form-check-label">Petrol Allowance (10000)</span>
                            </label>
                            <label class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="teachers[${idx}][pf]" value="1">
                                <span class="form-check-label">PF (8% of Basic)</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Custom Deduction Name</label>
                        <input type="text" class="form-control" name="teachers[${idx}][custom_deduction_name]">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Custom Deduction Amount / %</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="teachers[${idx}][custom_deduction_amount]">
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-end">
                        <label class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" name="teachers[${idx}][custom_deduction_is_percentage]" value="1">
                            <span class="form-check-label">Percentage</span>
                        </label>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label">Photo</label>
                        <input type="file" class="form-control" name="teachers[${idx}][photo]" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Last Degree Certificate</label>
                        <input type="file" class="form-control" name="teachers[${idx}][last_degree_certificate]" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">CNIC Front</label>
                        <input type="file" class="form-control" name="teachers[${idx}][cnic_front]" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">CNIC Back</label>
                        <input type="file" class="form-control" name="teachers[${idx}][cnic_back]" required>
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
                row.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], input[type="number"], textarea').forEach((el) => (el.value = ''));
                row.querySelectorAll('input[type="password"]').forEach((el) => (el.value = ''));
                row.querySelectorAll('input[type="file"]').forEach((el) => (el.value = ''));
                row.querySelectorAll('input[type="checkbox"]').forEach((el) => (el.checked = false));
                row.querySelectorAll('select').forEach((el) => (el.selectedIndex = 0));
                return;
            }

            row.remove();
            renumberRows();
        });
    });
</script>
@endpush
