<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Create Grade</h1>
            <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf
            @php
                $gradesOld = old('grades');
                if (!is_array($gradesOld) || count($gradesOld) === 0) {
                    $gradesOld = [[
                        'grade_name' => old('grade_name'),
                        'min_percentage' => old('min_percentage'),
                        'max_percentage' => old('max_percentage'),
                        'remark' => old('remark'),
                    ]];
                }
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold">Grades</div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add_grade_row">
                    <i class="fas fa-plus"></i> Add More
                </button>
            </div>

            <div id="grades_container">
                @foreach($gradesOld as $index => $row)
                    <div class="grade-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-2">
                                <label class="form-label">Grade Name</label>
                                <input type="text" name="grades[{{ $index }}][grade_name]" class="form-control" value="{{ data_get($row, 'grade_name') }}" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Min Percentage</label>
                                <input type="number" name="grades[{{ $index }}][min_percentage]" class="form-control" value="{{ data_get($row, 'min_percentage') }}" min="0" max="100" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Max Percentage</label>
                                <input type="number" name="grades[{{ $index }}][max_percentage]" class="form-control" value="{{ data_get($row, 'max_percentage') }}" min="0" max="100" required>
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="form-label">Remark</label>
                                <input type="text" name="grades[{{ $index }}][remark]" class="form-control" value="{{ data_get($row, 'remark') }}">
                            </div>
                            <div class="col-12 col-md-1 text-md-end">
                                <button type="button" class="btn btn-outline-danger w-100 remove-grade-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

                    <button type="submit" class="btn btn-primary">Create Grades</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('grades_container');
        const addBtn = document.getElementById('add_grade_row');

        function renumberItems() {
            const items = container.querySelectorAll('.grade-item');
            items.forEach((item, idx) => {
                item.querySelectorAll('[name]').forEach((el) => {
                    el.name = el.name.replace(/grades\[\d+\]/, `grades[${idx}]`);
                });
            });
        }

        function addItem() {
            const idx = container.querySelectorAll('.grade-item').length;
            const div = document.createElement('div');
            div.className = 'grade-item border rounded p-3 mb-3';
            div.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-2">
                        <label class="form-label">Grade Name</label>
                        <input type="text" name="grades[${idx}][grade_name]" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">Min Percentage</label>
                        <input type="number" name="grades[${idx}][min_percentage]" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">Max Percentage</label>
                        <input type="number" name="grades[${idx}][max_percentage]" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label">Remark</label>
                        <input type="text" name="grades[${idx}][remark]" class="form-control">
                    </div>
                    <div class="col-12 col-md-1 text-md-end">
                        <button type="button" class="btn btn-outline-danger w-100 remove-grade-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        addBtn.addEventListener('click', addItem);

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-grade-item');
            if (!btn) return;

            const item = btn.closest('.grade-item');
            const items = container.querySelectorAll('.grade-item');

            if (items.length <= 1) {
                item.querySelectorAll('input').forEach((el) => (el.value = ''));
                return;
            }

            item.remove();
            renumberItems();
        });
    });
</script>
@endpush
