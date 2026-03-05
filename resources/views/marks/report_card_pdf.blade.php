<!DOCTYPE html>
<html>
<head>
    <title>Report Card - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .student-info { margin-bottom: 20px; }
        .student-info p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>School Name</h1>
        <h2>{{ $exam->name }} Report Card</h2>
        <p>Session: {{ $exam->session_year }}</p>
    </div>

    <div class="student-info">
        <p><strong>Student Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
        <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
        <p><strong>Class:</strong> {{ $student->schoolClass->name }}</p>
        <p><strong>Section:</strong> {{ $student->section->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Max Marks</th>
                <th>Pass Marks</th>
                <th>Marks Obtained</th>
                <th>Grade</th>
                <th>Result</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row['subject'] }}</td>
                <td>{{ $row['max_marks'] }}</td>
                <td>{{ $row['pass_marks'] }}</td>
                <td>{{ $row['obtained'] }}</td>
                <td>{{ $row['grade'] }}</td>
                <td>{{ $row['is_pass'] ? 'Pass' : 'Fail' }}</td>
                <td>{{ $row['remarks'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total</th>
                <th>{{ $totalObtained }} / {{ $totalMax }}</th>
                <th colspan="3">
                    Percentage: {{ number_format($overallPercentage, 2) }}% 
                    (Grade: {{ $overallGrade ? $overallGrade->grade_name : 'N/A' }})
                </th>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 50px;">
        <p><strong>Date:</strong> {{ date('Y-m-d') }}</p>
        <p><strong>Principal Signature:</strong> _______________________</p>
    </div>
</body>
</html>
