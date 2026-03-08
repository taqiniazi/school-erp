@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Attendance Monthly Report</span>
        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <form action="{{ route('attendance.report') }}" method="GET" class="row g-3 mb-4">
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
            <div class="col-md-2">
                <label for="month" class="form-label">Month</label>
                <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label for="year" class="form-label">Year</label>
                <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                    @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" name="export_pdf" value="1" class="btn btn-danger w-100" {{ !$selectedClass || !$selectedSection ? 'disabled' : '' }}>Export PDF</button>
            </div>
        </form>

        @if($selectedClass && $selectedSection)
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Roll No</th>
                            <th>Student Name</th>
                            @for($i = 1; $i <= $daysInMonth; $i++)
                                <th class="text-center" style="font-size: 0.8rem; width: 30px;">{{ $i }}</th>
                            @endfor
                            <th class="text-center">P</th>
                            <th class="text-center">A</th>
                            <th class="text-center">L</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $studentAttendances = $attendances->get($student->id, collect());
                                $presentCount = $studentAttendances->where('status', 'present')->count();
                                $absentCount = $studentAttendances->where('status', 'absent')->count();
                                $lateCount = $studentAttendances->where('status', 'late')->count();
                            @endphp
                            <tr>
                                <td>{{ $student->roll_number }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                @for($i = 1; $i <= $daysInMonth; $i++)
                                    @php
                                        $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                                        $status = $studentAttendances->where('date', Carbon\Carbon::parse($date))->first()->status ?? '-';
                                        $color = match($status) {
                                            'present' => 'text-success fw-bold',
                                            'absent' => 'text-danger fw-bold',
                                            'late' => 'text-warning fw-bold',
                                            'half_day' => 'text-info fw-bold',
                                            'holiday' => 'text-secondary fw-bold',
                                            default => 'text-muted'
                                        };
                                        $display = match($status) {
                                            'present' => 'P',
                                            'absent' => 'A',
                                            'late' => 'L',
                                            'half_day' => 'HD',
                                            'holiday' => 'H',
                                            default => '-'
                                        };
                                    @endphp
                                    <td class="text-center {{ $color }}" title="{{ $status }}">{{ $display }}</td>
                                @endfor
                                <td class="text-center fw-bold text-success">{{ $presentCount }}</td>
                                <td class="text-center fw-bold text-danger">{{ $absentCount }}</td>
                                <td class="text-center fw-bold text-warning">{{ $lateCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">Select Class and Section to view report.</div>
        @endif
    </div>
</div>
@endsection


