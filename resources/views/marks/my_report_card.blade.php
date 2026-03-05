@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header">
        My Report Card
    </div>
    <div class="card-body">
        <form action="{{ route('student.report_card') }}" method="GET" class="row g-3 mb-4">
            @if(isset($children) && $children->count() > 1)
                <div class="col-md-3">
                    <label for="student_id" class="form-label">Select Child</label>
                    <select name="student_id" id="student_id" class="form-select" onchange="this.form.submit()">
                        @foreach($children as $child)
                            <option value="{{ $child->id }}" {{ $student->id == $child->id ? 'selected' : '' }}>
                                {{ $child->first_name }} {{ $child->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @elseif(isset($children) && $children->count() == 1)
                 <input type="hidden" name="student_id" value="{{ $children->first()->id }}">
            @endif

            <div class="col-md-3">
                <label for="exam_id" class="form-label">Select Exam</label>
                <select name="exam_id" id="exam_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Select Exam</option>
                    @foreach($exams as $e)
                        <option value="{{ $e->id }}" {{ ($exam && $exam->id == $e->id) ? 'selected' : '' }}>
                            {{ $e->name }} ({{ $e->session_year }})
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if($exam)
            <div class="card border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>Report Card: {{ $exam->name }}</span>
                    <a href="{{ route('student.report_card', array_merge(request()->all(), ['export_pdf' => 1])) }}" class="btn btn-sm btn-light text-primary">Download PDF</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Student Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                            <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Class:</strong> {{ $student->schoolClass->name }} - {{ $student->section->name }}</p>
                            <p><strong>Session:</strong> {{ $exam->session_year }}</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Max Marks</th>
                                    <th>Pass Marks</th>
                                    <th>Obtained</th>
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
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">Total</td>
                                    <td>{{ $totalObtained }} / {{ $totalMax }}</td>
                                    <td colspan="3">
                                        Percentage: {{ number_format($overallPercentage, 2) }}% 
                                        (Grade: {{ $overallGrade ? $overallGrade->grade_name : 'N/A' }})
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($exams->isEmpty())
            <div class="alert alert-info">No published exams available yet.</div>
        @else
            <div class="alert alert-info">Please select an exam to view the report card.</div>
        @endif
    </div>
</div>
@endsection
