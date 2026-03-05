@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Report Card: {{ $student->first_name }} {{ $student->last_name }}</span>
        <div>
            <a href="{{ route('marks.generate_report_card', ['exam_id' => $exam->id, 'student_id' => $student->id, 'export_pdf' => 1]) }}" class="btn btn-sm btn-danger">Download PDF</a>
            <a href="{{ route('marks.report_card') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
    <div class="card-body">
        <div class="text-center mb-4">
            <h3>School Name</h3>
            <h4>{{ $exam->name }} Report Card</h4>
            <p>Session: {{ $exam->session_year }}</p>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Student Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Class:</strong> {{ $student->schoolClass->name }}</p>
                <p><strong>Section:</strong> {{ $student->section->name }}</p>
            </div>
        </div>

        <table class="table table-bordered table-striped">
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
                    <td>
                        @if($row['is_pass'])
                            <span class="badge bg-success">Pass</span>
                        @else
                            <span class="badge bg-danger">Fail</span>
                        @endif
                    </td>
                    <td>{{ $row['remarks'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>{{ $totalObtained }} / {{ $totalMax }}</th>
                    <th colspan="3">
                        Percentage: {{ number_format($overallPercentage, 2) }}% 
                        (Grade: {{ $overallGrade ? $overallGrade->grade_name : 'N/A' }})
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
