﻿@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Exam Schedule: {{ $exam->name }}</span>
        <a href="{{ route('exams.index') }}" class="btn btn-sm btn-secondary">Back to Exams</a>
    </div>
    <div class="card-body">
        <form action="{{ route('exams.schedules.store', $exam) }}" method="POST" class="row g-3 mb-4">
            @csrf
            <div class="col-md-3">
                <label for="school_class_id" class="form-label">Class</label>
                <select name="school_class_id" id="school_class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="exam_date" class="form-label">Date</label>
                <input type="date" name="exam_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="max_marks" class="form-label">Max Marks</label>
                <input type="number" name="max_marks" class="form-control" value="100" required>
            </div>
            <div class="col-md-2">
                <label for="pass_marks" class="form-label">Pass Marks</label>
                <input type="number" name="pass_marks" class="form-control" value="40" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Add Schedule</button>
            </div>
        </form>

        <hr>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Max Marks</th>
                        <th>Pass Marks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exam->schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->schoolClass->name }}</td>
                        <td>{{ $schedule->subject->name }}</td>
                        <td>{{ $schedule->exam_date->format('Y-m-d') }}</td>
                        <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                        <td>{{ $schedule->max_marks }}</td>
                        <td>{{ $schedule->pass_marks }}</td>
                        <td>
                            <form action="{{ route('exams.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


