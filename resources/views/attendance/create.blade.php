@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Take Attendance</span>
        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-secondary">View History</a>
    </div>
    <div class="card-body">
        <form action="{{ route('attendance.create') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="school_class_id" class="form-label">Class</label>
                <select name="school_class_id" id="school_class_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="section_id" class="form-label">Section</label>
                <select name="section_id" id="section_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ $selectedSection == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Load Students</button>
            </div>
        </form>

        @if(count($students) > 0)
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="school_class_id" value="{{ $selectedClass }}">
            <input type="hidden" name="section_id" value="{{ $selectedSection }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="d-flex justify-content-between mb-3">
                <h5>Students ({{ count($students) }})</h5>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="markAll('present')">Mark All Present</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Roll No</th>
                            <th>Name</th>
                            <th class="text-center" style="min-width: 200px;">Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $status = $existingAttendance[$student->id]->status ?? 'present';
                                $remarks = $existingAttendance[$student->id]->remarks ?? '';
                            @endphp
                        <tr>
                            <td>{{ $student->roll_number }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="text-center">
                                <input type="hidden" name="attendances[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_p_{{ $student->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-success" for="status_p_{{ $student->id }}">P</label>

                                    <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_a_{{ $student->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger" for="status_a_{{ $student->id }}">A</label>

                                    <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_l_{{ $student->id }}" value="late" {{ $status == 'late' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning" for="status_l_{{ $student->id }}">L</label>
                                    
                                    <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_h_{{ $student->id }}" value="half_day" {{ $status == 'half_day' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-info" for="status_h_{{ $student->id }}">HD</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="attendances[{{ $student->id }}][remarks]" class="form-control form-control-sm" value="{{ $remarks }}" placeholder="Optional">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                <button type="submit" class="btn btn-success btn-lg">Save Attendance</button>
            </div>
        </form>
        @elseif($selectedClass && $selectedSection)
            <div class="alert alert-info">No students found in this class/section.</div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function markAll(status) {
        document.querySelectorAll(`input[value="${status}"]`).forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endpush
@endsection