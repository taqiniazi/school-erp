@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header">
        Create Exam
    </div>
    <div class="card-body">
        <form action="{{ route('exams.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Exam Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="session_year" class="form-label">Session Year</label>
                <input type="text" name="session_year" class="form-control" id="session_year" required>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" id="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" id="end_date" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Exam</button>
        </form>
    </div>
</div>
@endsection
