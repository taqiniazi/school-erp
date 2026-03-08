@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Take Teacher Attendance</span>
        <a href="{{ route('teacher-attendance.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher-attendance.create') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
            </div>
        </form>

        <form action="{{ route('teacher-attendance.store') }}" method="POST">
            @csrf
            <input type="d-none" name="date" value="{{ $date }}">
            
            <div class="mb-3 d-flex g-2">
                <button type="button" class="btn btn-sm btn-outline-success" onclick="markAll('present')">Mark All Present</button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="markAll('absent')">Mark All Absent</button>
                <button type="button" class="btn btn-sm btn-outline-warning" onclick="markAll('holiday')">Mark All Holiday</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Teacher Name</th>
                            <th class="text-center" style="width: 350px;">Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            @php
                                $status = $existingAttendance[$teacher->id]->status ?? 'present';
                                $remarks = $existingAttendance[$teacher->id]->remarks ?? '';
                            @endphp
                            <tr>
                                <td>
                                    {{ $teacher->name }}
                                    <input type="d-none" name="attendances[{{ $teacher->id }}][teacher_id]" value="{{ $teacher->id }}">
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_p_{{ $teacher->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-success" for="status_p_{{ $teacher->id }}">P</label>

                                        <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_a_{{ $teacher->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger" for="status_a_{{ $teacher->id }}">A</label>

                                        <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_l_{{ $teacher->id }}" value="late" {{ $status == 'late' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning" for="status_l_{{ $teacher->id }}">L</label>

                                        <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_h_{{ $teacher->id }}" value="half_day" {{ $status == 'half_day' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-info" for="status_h_{{ $teacher->id }}">HD</label>
                                        
                                        <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_hol_{{ $teacher->id }}" value="holiday" {{ $status == 'holiday' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary" for="status_hol_{{ $teacher->id }}">H</label>
                                        
                                        <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_lev_{{ $teacher->id }}" value="leave" {{ $status == 'leave' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="status_lev_{{ $teacher->id }}">LV</label>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="attendances[{{ $teacher->id }}][remarks]" class="form-control form-control-sm" placeholder="Remarks" value="{{ $remarks }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Attendance</button>
        </form>
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


