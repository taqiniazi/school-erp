﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Teacher Attendance Monthly Report</h1>
            <a href="{{ route('teacher-attendance.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
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
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teacher Name</th>
                                @for($i = 1; $i <= $daysInMonth; $i++)
                                    <th class="p-3 text-center small fw-medium text-secondary text-uppercase" style="font-size: 0.8rem; width: 30px;">{{ $i }}</th>
                                @endfor
                                <th class="p-3 text-center small fw-medium text-secondary text-uppercase">P</th>
                                <th class="p-3 text-center small fw-medium text-secondary text-uppercase">A</th>
                                <th class="p-3 text-center small fw-medium text-secondary text-uppercase">L</th>
                                <th class="p-3 text-center small fw-medium text-secondary text-uppercase">LV</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                                @php
                                    $teacherAttendances = $attendances->get($teacher->id, collect());
                                    $presentCount = $teacherAttendances->where('status', 'present')->count();
                                    $absentCount = $teacherAttendances->where('status', 'absent')->count();
                                    $lateCount = $teacherAttendances->where('status', 'late')->count();
                                    $leaveCount = $teacherAttendances->where('status', 'leave')->count();
                                @endphp
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $teacher->name }}</td>
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
                                        <td class="p-3 text-center {{ $color }}" title="{{ $status }}">{{ $display }}</td>
                                    @endfor
                                    <td class="p-3 text-center fw-bold text-success">{{ $presentCount }}</td>
                                    <td class="p-3 text-center fw-bold text-danger">{{ $absentCount }}</td>
                                    <td class="p-3 text-center fw-bold text-warning">{{ $lateCount }}</td>
                                    <td class="p-3 text-center fw-bold text-primary">{{ $leaveCount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
