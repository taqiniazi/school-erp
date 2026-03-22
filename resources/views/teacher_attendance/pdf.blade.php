﻿<!DOCTYPE html>
<html>
<head>
    <title>Teacher Attendance Report</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-start { text-align: left; }
        .legend { margin-top: 10px; font-size: 9px; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Teacher Attendance Report - {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h2>
    
    <table>
        <thead>
            <tr>
                <th class="text-start" style="width: 100px;">Teacher Name</th>
                @for($i = 1; $i <= $daysInMonth; $i++)
                    <th style="width: 15px;">{{ $i }}</th>
                @endfor
                <th>P</th>
                <th>A</th>
                <th>L</th>
                <th>LV</th>
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
                    <td class="text-start">{{ $teacher->name }}</td>
                    @for($i = 1; $i <= $daysInMonth; $i++)
                        @php
                            $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                            $status = $teacherAttendances->where('date', Carbon\Carbon::parse($date))->first()->status ?? '-';
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
                        <td>{{ $display }}</td>
                    @endfor
                    <td>{{ $presentCount }}</td>
                    <td>{{ $absentCount }}</td>
                    <td>{{ $lateCount }}</td>
                    <td>{{ $leaveCount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <strong>Legend:</strong> P: Present, A: Absent, L: Late, HD: Half Day, H: Holiday, LV: Leave
    </div>
</body>
</html>
