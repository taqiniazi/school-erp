<!DOCTYPE html>
<html>
<head>
    <title>Academic Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Academic Report: Student List</h2>
    <table>
        <thead>
            <tr>
                <th>Admission No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Roll No</th>
                <th>Gender</th>
                <th>DOB</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->admission_number }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->schoolClass->name ?? 'N/A' }}</td>
                    <td>{{ $student->section->name ?? 'N/A' }}</td>
                    <td>{{ $student->roll_number }}</td>
                    <td>{{ ucfirst($student->gender) }}</td>
                    <td>{{ $student->dob }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>