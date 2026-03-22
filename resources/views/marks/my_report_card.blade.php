﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">My Report Card</h1>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
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
            <div class="card border-0 shadow-sm rounded-3">
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
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Max Marks</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Pass Marks</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Obtained</th>
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
                                <tr class="fw-bold">
                                    <td colspan="3" class="p-3 text-end">Total</td>
                                    <td class="p-3 text-nowrap">{{ $totalObtained }} / {{ $totalMax }}</td>
                                    <td colspan="3" class="p-3">
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
            @if(! empty($hasUnpublishedResults))
                <div class="alert alert-info">Report card is not published yet. Please contact the school.</div>
            @else
                <div class="alert alert-info">No report card available yet.</div>
            @endif
        @else
            <div class="alert alert-info">Please select an exam to view the report card.</div>
        @endif
            </div>
        </div>
    </div>
</x-app-layout>
