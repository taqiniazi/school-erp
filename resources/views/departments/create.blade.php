<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold">Create Department</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.store') }}" method="POST">
                            @csrf
                            @php
                                $departmentsOld = old('departments');
                                if (!is_array($departmentsOld) || count($departmentsOld) === 0) {
                                    $departmentsOld = [[
                                        'name' => old('name'),
                                        'description' => old('description'),
                                        'is_active' => old('is_active', true),
                                    ]];
                                }
                            @endphp

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-semibold">Departments</div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add_department_row">
                                    <i class="fas fa-plus"></i> Add More
                                </button>
                            </div>

                            <div id="departments_container">
                                @foreach($departmentsOld as $index => $row)
                                    <div class="department-item border rounded p-3 mb-3">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="departments[{{ $index }}][name]" class="form-control" value="{{ data_get($row, 'name') }}" required>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label class="form-label">Description</label>
                                                <input type="text" name="departments[{{ $index }}][description]" class="form-control" value="{{ data_get($row, 'description') }}">
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="departments_active_{{ $index }}" name="departments[{{ $index }}][is_active]" {{ data_get($row, 'is_active', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="departments_active_{{ $index }}">Active</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1 text-md-end">
                                                <button type="button" class="btn btn-outline-danger w-100 remove-department-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-end g-2">
                                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('departments_container');
            const addBtn = document.getElementById('add_department_row');

            function renumberItems() {
                const items = container.querySelectorAll('.department-item');
                items.forEach((item, idx) => {
                    item.querySelectorAll('input[name]').forEach((input) => {
                        input.name = input.name.replace(/departments\[\d+\]/, `departments[${idx}]`);
                    });
                    const checkbox = item.querySelector('input[type="checkbox"][id^="departments_active_"]');
                    const label = item.querySelector('label[for^="departments_active_"]');
                    if (checkbox) checkbox.id = `departments_active_${idx}`;
                    if (label) label.setAttribute('for', `departments_active_${idx}`);
                });
            }

            function addRow() {
                const idx = container.querySelectorAll('.department-item').length;
                const div = document.createElement('div');
                div.className = 'department-item border rounded p-3 mb-3';
                div.innerHTML = `
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="departments[${idx}][name]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-5">
                            <label class="form-label">Description</label>
                            <input type="text" name="departments[${idx}][description]" class="form-control">
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="departments_active_${idx}" name="departments[${idx}][is_active]" checked>
                                <label class="form-check-label" for="departments_active_${idx}">Active</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-1 text-md-end">
                            <button type="button" class="btn btn-outline-danger w-100 remove-department-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            }

            addBtn.addEventListener('click', addRow);

            container.addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-department-item');
                if (!btn) return;
                const items = container.querySelectorAll('.department-item');
                const item = btn.closest('.department-item');
                if (items.length <= 1) {
                    item.querySelectorAll('input[type="text"]').forEach((input) => input.value = '');
                    item.querySelectorAll('input[type="checkbox"]').forEach((input) => input.checked = true);
                    return;
                }
                item.remove();
                renumberItems();
            });
        });
    </script>
    @endpush
</x-app-layout>
