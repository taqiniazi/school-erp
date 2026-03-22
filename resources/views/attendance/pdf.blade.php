﻿<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-start { text-align: left; }
        .header { margin-bottom: 20px; }
        .legend { margin-top: 10px; font-size: 9px; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="text-align: center;">Student Attendance Report</h2>
        <p style="text-align: center;">
            <strong>Class:</strong> {{ $className }} - {{ $sectionName }} | 
            <strong>Month:</strong> {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
        </p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th class="text-start" style="width: 50px;">Roll No</th>
                <th class="text-start" style="width: 100px;">Student Name</th>
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
            @foreach($students as $student)
                @php
                    $studentAttendances = $attendances->get($student->id, collect());
                    $presentCount = $studentAttendances->where('status', 'present')->count();
                    $absentCount = $studentAttendances->where('status', 'absent')->count();
                    $lateCount = $studentAttendances->where('status', 'late')->count();
                    $leaveCount = $studentAttendances->where('status', 'leave')->count();
                @endphp
                <tr>
                    <td class="text-start">{{ $student->roll_number }}</td>
                    <td class="text-start">{{ $student->first_name }} {{ $student->last_name }}</td>
                    @for($i = 1; $i <= $daysInMonth; $i++)
                        @php
                            $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                            $status = $studentAttendances->where('date', Carbon\Carbon::parse($date))->first()->status ?? '-';
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
        <strong>Legend:</strong> P: Present, A: Absent, L: Late, LV: Leave, HD: Half Day, H: Holiday
    </div>
</body>
</html>
