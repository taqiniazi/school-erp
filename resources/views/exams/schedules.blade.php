<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Exam Schedule: {{ $exam->name }}</h1>
            <a href="{{ route('exams.index') }}" class="btn btn-secondary">Back to Exams</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('exams.schedules.store', $exam) }}" method="POST" class="mb-4">
                    @csrf
            @php
                $schedulesOld = old('schedules');
                if (!is_array($schedulesOld) || count($schedulesOld) === 0) {
                    $schedulesOld = [[
                        'school_class_id' => old('school_class_id'),
                        'subject_id' => old('subject_id'),
                        'exam_date' => old('exam_date'),
                        'start_time' => old('start_time'),
                        'end_time' => old('end_time'),
                        'max_marks' => old('max_marks', 100),
                        'pass_marks' => old('pass_marks', 40),
                    ]];
                }
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold">Schedules</div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add_schedule_row">
                    <i class="fas fa-plus"></i> Add More
                </button>
            </div>

            <div id="schedules_container">
                @foreach($schedulesOld as $index => $row)
                    <div class="schedule-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-3">
                                <label class="form-label">Class</label>
                                <select name="schedules[{{ $index }}][school_class_id]" class="form-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ (string) data_get($row, 'school_class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Subject</label>
                                <select name="schedules[{{ $index }}][subject_id]" class="form-select" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ (string) data_get($row, 'subject_id') === (string) $subject->id ? 'selected' : '' }}>{{ $subject->name }} ({{ $subject->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Date</label>
                                <input type="date" name="schedules[{{ $index }}][exam_date]" class="form-control" value="{{ data_get($row, 'exam_date') }}" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Start Time</label>
                                <input type="time" name="schedules[{{ $index }}][start_time]" class="form-control" value="{{ data_get($row, 'start_time') }}" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">End Time</label>
                                <input type="time" name="schedules[{{ $index }}][end_time]" class="form-control" value="{{ data_get($row, 'end_time') }}" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Max Marks</label>
                                <input type="number" name="schedules[{{ $index }}][max_marks]" class="form-control" value="{{ data_get($row, 'max_marks', 100) }}" required min="1">
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Pass Marks</label>
                                <input type="number" name="schedules[{{ $index }}][pass_marks]" class="form-control" value="{{ data_get($row, 'pass_marks', 40) }}" required min="0">
                            </div>
                            <div class="col-12 col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-danger w-100 remove-schedule-item">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save Schedules</button>
            </div>
        </form>

        <hr>

                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Time</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Max Marks</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Pass Marks</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exam->schedules as $schedule)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $schedule->schoolClass->name }}</td>
                                <td class="p-3 text-nowrap">{{ $schedule->subject->name }}</td>
                                <td class="p-3 text-nowrap">{{ $schedule->exam_date->format('Y-m-d') }}</td>
                                <td class="p-3 text-nowrap">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                <td class="p-3 text-nowrap">{{ $schedule->max_marks }}</td>
                                <td class="p-3 text-nowrap">{{ $schedule->pass_marks }}</td>
                                <td class="p-3 text-nowrap text-end">
                                    <form action="{{ route('exams.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('schedules_container');
        const addBtn = document.getElementById('add_schedule_row');

        function renumberItems() {
            const items = container.querySelectorAll('.schedule-item');
            items.forEach((item, idx) => {
                item.querySelectorAll('[name]').forEach((el) => {
                    el.name = el.name.replace(/schedules\[\d+\]/, `schedules[${idx}]`);
                });
            });
        }

        function addRow() {
            const idx = container.querySelectorAll('.schedule-item').length;
            const div = document.createElement('div');
            div.className = 'schedule-item border rounded p-3 mb-3';
            div.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label">Class</label>
                        <select name="schedules[${idx}][school_class_id]" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Subject</label>
                        <select name="schedules[${idx}][subject_id]" class="form-select" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">Date</label>
                        <input type="date" name="schedules[${idx}][exam_date]" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="schedules[${idx}][start_time]" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">End Time</label>
                        <input type="time" name="schedules[${idx}][end_time]" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">Max Marks</label>
                        <input type="number" name="schedules[${idx}][max_marks]" class="form-control" value="100" required min="1">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label">Pass Marks</label>
                        <input type="number" name="schedules[${idx}][pass_marks]" class="form-control" value="40" required min="0">
                    </div>
                    <div class="col-12 col-md-2 text-md-end">
                        <button type="button" class="btn btn-outline-danger w-100 remove-schedule-item">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        addBtn.addEventListener('click', addRow);

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-schedule-item');
            if (!btn) return;
            const item = btn.closest('.schedule-item');
            const items = container.querySelectorAll('.schedule-item');

            if (items.length <= 1) {
                item.querySelectorAll('input').forEach((el) => (el.value = ''));
                item.querySelectorAll('select').forEach((el) => (el.selectedIndex = 0));
                item.querySelector('input[name*="[max_marks]"]').value = 100;
                item.querySelector('input[name*="[pass_marks]"]').value = 40;
                return;
            }

            item.remove();
            renumberItems();
        });
    });
</script>
@endpush
