@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Teacher Attendance History</span>
        <div>
            <a href="{{ route('teacher-attendance.report') }}" class="btn btn-sm btn-info text-white">Monthly Report</a>
            <a href="{{ route('teacher-attendance.create') }}" class="btn btn-sm btn-primary">Take Attendance</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher-attendance.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
            </div>
        </form>

        @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Teacher Name</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->teacher->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $attendance->status == 'present' ? 'success' : ($attendance->status == 'absent' ? 'danger' : 'warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                    </span>
                                </td>
                                <td>{{ $attendance->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">No attendance records found for this date.</div>
        @endif
    </div>
</div>
@endsection


