﻿@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Exams List</span>
        <a href="{{ route('exams.create') }}" class="btn btn-sm btn-primary">Create Exam</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Session</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    <tr>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->session_year }}</td>
                        <td>{{ $exam->start_date->format('Y-m-d') }}</td>
                        <td>{{ $exam->end_date->format('Y-m-d') }}</td>
                        <td>
                            @if($exam->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('exams.schedules', $exam) }}" class="btn btn-sm btn-info text-white">Schedule</a>
                            <a href="{{ route('exams.edit', $exam) }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            @if($exam->is_published)
                                <form action="{{ route('exams.unpublish', $exam) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary">Unpublish</button>
                                </form>
                            @else
                                <form action="{{ route('exams.publish', $exam) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Publish</button>
                                </form>
                            @endif

                            <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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


