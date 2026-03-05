@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            Marks Entry: 
            <strong>{{ $exam->name }}</strong> - 
            {{ $class->name }} {{ $section->name }} - 
            {{ $subject->name }}
            (Max Marks: {{ $schedule->max_marks }})
        </span>
        <a href="{{ route('marks.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <form action="{{ route('marks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_schedule_id" value="{{ $schedule->id }}">
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Roll No</th>
                            <th>Student Name</th>
                            <th>Marks Obtained (Max: {{ $schedule->max_marks }})</th>
                            <th>Remarks</th>
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
                            <td>{{ $student->roll_number }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>
                                <input type="number" 
                                       name="marks[{{ $student->id }}]" 
                                       class="form-control mark-input" 
                                       value="{{ $marksObtained }}" 
                                       min="0" 
                                       max="{{ $schedule->max_marks }}"
                                       step="1">
                            </td>
                            <td>
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
            
            <button type="submit" class="btn btn-success mt-3">Save Marks</button>
        </form>
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
@endsection
