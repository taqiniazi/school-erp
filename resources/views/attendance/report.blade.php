﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Attendance Monthly Report</h1>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
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
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Roll No</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student Name</th>
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
                                @foreach($students as $student)
                                    @php
                                        $studentAttendances = $attendances->get($student->id, collect());
                                        $presentCount = $studentAttendances->where('status', 'present')->count();
                                        $absentCount = $studentAttendances->where('status', 'absent')->count();
                                        $lateCount = $studentAttendances->where('status', 'late')->count();
                                        $leaveCount = $studentAttendances->where('status', 'leave')->count();
                                    @endphp
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $student->roll_number }}</td>
                                        <td class="p-3 text-nowrap">{{ $student->first_name }} {{ $student->last_name }}</td>
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
                                                    'leave' => 'text-primary fw-bold',
                                                    default => 'text-muted'
                                                };
                                                $display = match($status) {
                                                    'present' => 'P',
                                                    'absent' => 'A',
                                                    'late' => 'L',
                                                    'leave' => 'LV',
                                                    'half_day' => 'HD',
                                                    'holiday' => 'H',
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
                @else
                    <div class="alert alert-info mb-0">Select Class and Section to view report.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
