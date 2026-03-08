@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Create Grade
    </div>
    <div class="card-body">
        <form action="{{ route('grades.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="grade_name" class="form-label">Grade Name</label>
                <input type="text" name="grade_name" class="form-control" id="grade_name" required>
            </div>
            <div class="mb-3">
                <label for="min_percentage" class="form-label">Min Percentage</label>
                <input type="number" name="min_percentage" class="form-control" id="min_percentage" required>
            </div>
            <div class="mb-3">
                <label for="max_percentage" class="form-label">Max Percentage</label>
                <input type="number" name="max_percentage" class="form-control" id="max_percentage" required>
            </div>
            <div class="mb-3">
                <label for="remark" class="form-label">Remark</label>
                <input type="text" name="remark" class="form-control" id="remark">
            </div>
            <button type="submit" class="btn btn-primary">Create Grade</button>
        </form>
    </div>
</div>
@endsection
