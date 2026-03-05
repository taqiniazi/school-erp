@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Grade
    </div>
    <div class="card-body">
        <form action="{{ route('grades.update', $grade) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="grade_name" class="form-label">Grade Name</label>
                <input type="text" name="grade_name" class="form-control" id="grade_name" value="{{ $grade->grade_name }}" required>
            </div>
            <div class="mb-3">
                <label for="min_percentage" class="form-label">Min Percentage</label>
                <input type="number" name="min_percentage" class="form-control" id="min_percentage" value="{{ $grade->min_percentage }}" required>
            </div>
            <div class="mb-3">
                <label for="max_percentage" class="form-label">Max Percentage</label>
                <input type="number" name="max_percentage" class="form-control" id="max_percentage" value="{{ $grade->max_percentage }}" required>
            </div>
            <div class="mb-3">
                <label for="remark" class="form-label">Remark</label>
                <input type="text" name="remark" class="form-control" id="remark" value="{{ $grade->remark }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Grade</button>
        </form>
    </div>
</div>
@endsection
