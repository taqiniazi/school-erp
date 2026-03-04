@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Teacher Attendance Monthly Report</span>
        <a href="{{ route('teacher-attendance.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher-attendance.report') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="month" class="form-label">Month</label>
                <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label">Year</label>
                <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                    @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" name="export_pdf" value="1" class="btn btn-danger w-100">Export to PDF</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Teacher Name</th>
                        @for($i = 1; $i <= $daysInMonth; $i++)
                            <th class="text-center" style="font-size: 0.8rem; width: 30px;">{{ $i }}</th>
                        @endfor
                        <th class="text-center">P</th>
                        <th class="text-center">A</th>
                        <th class="text-center">L</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                        @php
                            $teacherAttendances = $attendances->get($teacher->id, collect());
                            $presentCount = $teacherAttendances->where('status', 'present')->count();
                            $absentCount = $teacherAttendances->where('status', 'absent')->count();
                            $leaveCount = $teacherAttendances->where('status', 'leave')->count();
                        @endphp
                        <tr>
                            <td>{{ $teacher->name }}</td>
                            @for($i = 1; $i <= $daysInMonth; $i++)
                                @php
                                    $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                                    $status = $teacherAttendances->where('date', Carbon\Carbon::parse($date))->first()->status ?? '-';
                                    $color = match($status) {
                                        'present' => 'text-success fw-bold',
                                        'absent' => 'text-danger fw-bold',
                                        'late' => 'text-warning fw-bold',
                                        'half_day' => 'text-info fw-bold',
                                        'holiday' => 'text-secondary fw-bold',
                                        'leave' => 'text-primary fw-bold',
                                        default => 'text-muted'
                                    };
                                    $display = match($status) {
                                        'present' => 'P',
                                        'absent' => 'A',
                                        'late' => 'L',
                                        'half_day' => 'HD',
                                        'holiday' => 'H',
                                        'leave' => 'LV',
                                        default => '-'
                                    };
                                @endphp
                                <td class="text-center {{ $color }}" title="{{ $status }}">{{ $display }}</td>
                            @endfor
                            <td class="text-center fw-bold text-success">{{ $presentCount }}</td>
                            <td class="text-center fw-bold text-danger">{{ $absentCount }}</td>
                            <td class="text-center fw-bold text-primary">{{ $leaveCount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
