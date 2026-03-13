<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">
                Marks Entry: <span class="fw-semibold">{{ $exam->name }}</span> - {{ $class->name }} {{ $section->name }} - {{ $subject->name }}
                <span class="text-muted fw-normal">(Max Marks: {{ $schedule->max_marks }})</span>
            </h1>
            <a href="{{ route('marks.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('marks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="exam_schedule_id" value="{{ $schedule->id }}">

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Roll No</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Marks Obtained (Max: {{ $schedule->max_marks }})</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                @php
                                    $mark = $existingMarks[$student->id] ?? null;
                                    $marksObtained = $mark ? $mark->marks_obtained : '';
                                    $remarks = $mark ? $mark->remarks : '';
                                @endphp
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $student->roll_number }}</td>
                                    <td class="p-3 text-nowrap">{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td class="p-3">
                                        <input type="number"
                                               name="marks[{{ $student->id }}]"
                                               class="form-control mark-input"
                                               value="{{ $marksObtained }}"
                                               min="0"
                                               max="{{ $schedule->max_marks }}"
                                               step="1">
                                    </td>
                                    <td class="p-3">
                                        <input type="text"
                                               name="remarks[{{ $student->id }}]"
                                               class="form-control"
                                               value="{{ $remarks }}"
                                               placeholder="Optional">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success mt-4">Save Marks</button>
                </form>
            </div>
        </div>
    </div>

<script>
    document.querySelectorAll('.mark-input').forEach(input => {
        input.addEventListener('input', function() {
            var max = {{ $schedule->max_marks }};
            if (this.value > max) {
                alert('Marks cannot exceed ' + max);
                this.value = max;
            }
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });
</script>
</x-app-layout>


