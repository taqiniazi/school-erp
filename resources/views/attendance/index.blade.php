@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Attendance History</span>
        <div>
            <a href="{{ route('attendance.report') }}" class="btn btn-sm btn-info text-white">Monthly Report</a>
            <a href="{{ route('attendance.create') }}" class="btn btn-sm btn-primary">Take Attendance</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('attendance.index') }}" method="GET" class="row g-3 mb-4">
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
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>

        @if(count($attendances) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Student Name</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->student->roll_number }}</td>
                        <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
                        <td>
                            <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : ($attendance->status === 'late' ? 'warning' : 'info')) }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>{{ $attendance->remarks }}</td>
                        <td>{{ $attendance->recordedBy->name ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif($selectedClass && $selectedSection)
            <div class="alert alert-warning">
                No attendance records found for this date. 
                <a href="{{ route('attendance.create', ['school_class_id' => $selectedClass, 'section_id' => $selectedSection, 'date' => $date]) }}" class="alert-link">Take Attendance Now</a>
            </div>
        @else
            <div class="alert alert-info">Select Class and Section to view attendance.</div>
        @endif
    </div>
</div>
@endsection

