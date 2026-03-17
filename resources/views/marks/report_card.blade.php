﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Report Card: {{ $student->first_name }} {{ $student->last_name }}</h1>
            <div class="btn-group">
                <a href="{{ route('marks.generate_report_card', ['exam_id' => $exam->id, 'student_id' => $student->id, 'export_pdf' => 1]) }}" class="btn btn-danger">Download PDF</a>
                <a href="{{ route('marks.report_card') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
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

        <div class="table-responsive">
        <table class="table table-hover w-100 mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Max Marks</th>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Pass Marks</th>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Marks Obtained</th>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Grade</th>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Result</th>
                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <td class="p-3">{{ $row['subject'] }}</td>
                    <td class="p-3 text-nowrap">{{ $row['max_marks'] }}</td>
                    <td class="p-3 text-nowrap">{{ $row['pass_marks'] }}</td>
                    <td class="p-3 text-nowrap">{{ $row['obtained'] }}</td>
                    <td class="p-3 text-nowrap">{{ $row['grade'] }}</td>
                    <td>
                        @if($row['is_pass'])
                            <span class="badge bg-success">Pass</span>
                        @else
                            <span class="badge bg-danger">Fail</span>
                        @endif
                    </td>
                    <td class="p-3">{{ $row['remarks'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="p-3 text-end">Total</th>
                    <th class="p-3 text-nowrap">{{ $totalObtained }} / {{ $totalMax }}</th>
                    <th colspan="3" class="p-3">
                        Percentage: {{ number_format($overallPercentage, 2) }}% 
                        (Grade: {{ $overallGrade ? $overallGrade->grade_name : 'N/A' }})
                    </th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>
</div>
    </div>
</x-app-layout>

