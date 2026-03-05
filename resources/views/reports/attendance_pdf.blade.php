<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Attendance Report: {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th>Admission No</th>
                <th>Name</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Late</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $record)
                <tr>
                    <td>{{ $record['student']->admission_number }}</td>
                    <td>{{ $record['student']->first_name }} {{ $record['student']->last_name }}</td>
                    <td>{{ $record['present'] }}</td>
                    <td>{{ $record['absent'] }}</td>
                    <td>{{ $record['late'] }}</td>
                    <td>{{ $record['percentage'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>