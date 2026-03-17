<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Create Subject</h1>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf

            @php
                $subjectsOld = old('subjects');
                if (!is_array($subjectsOld) || count($subjectsOld) === 0) {
                    $subjectsOld = [[
                        'code' => old('code'),
                        'name' => old('name'),
                        'type' => old('type', 'theory'),
                    ]];
                }
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold">Subjects</div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add_subject_row">
                    <i class="fas fa-plus"></i> Add More
                </button>
            </div>

            <div id="subjects_container">
                @foreach($subjectsOld as $index => $row)
                    <div class="subject-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="subjects[{{ $index }}][code]" class="form-control" value="{{ data_get($row, 'code') }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" name="subjects[{{ $index }}][name]" class="form-control" value="{{ data_get($row, 'name') }}" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Type</label>
                                <select name="subjects[{{ $index }}][type]" class="form-select" required>
                                    <option value="theory" {{ data_get($row, 'type', 'theory') === 'theory' ? 'selected' : '' }}>Theory</option>
                                    <option value="practical" {{ data_get($row, 'type', 'theory') === 'practical' ? 'selected' : '' }}>Practical</option>
                                    <option value="both" {{ data_get($row, 'type', 'theory') === 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-1 text-md-end">
                                <button type="button" class="btn btn-outline-danger w-100 remove-subject-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('subjects_container');
            const addBtn = document.getElementById('add_subject_row');

            function renumberItems() {
                const items = container.querySelectorAll('.subject-item');
                items.forEach((item, idx) => {
                    item.querySelectorAll('[name]').forEach((el) => {
                        el.name = el.name.replace(/subjects\[\d+\]/, `subjects[${idx}]`);
                    });
                });
            }

            function addItem() {
                const idx = container.querySelectorAll('.subject-item').length;
                const div = document.createElement('div');
                div.className = 'subject-item border rounded p-3 mb-3';
                div.innerHTML = `
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="subjects[${idx}][code]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="subjects[${idx}][name]" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Type</label>
                            <select name="subjects[${idx}][type]" class="form-select" required>
                                <option value="theory" selected>Theory</option>
                                <option value="practical">Practical</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-1 text-md-end">
                            <button type="button" class="btn btn-outline-danger w-100 remove-subject-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            }

            addBtn.addEventListener('click', addItem);

            container.addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-subject-item');
                if (!btn) return;
                const items = container.querySelectorAll('.subject-item');
                const item = btn.closest('.subject-item');
                if (items.length <= 1) {
                    item.querySelectorAll('input[type="text"]').forEach((input) => input.value = '');
                    const select = item.querySelector('select');
                    if (select) select.value = 'theory';
                    return;
                }
                item.remove();
                renumberItems();
            });
        });
    </script>
    @endpush
</x-app-layout>
