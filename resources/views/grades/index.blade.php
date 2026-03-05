@extends('layouts.bootstrap')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Grade System</span>
        <a href="{{ route('grades.create') }}" class="btn btn-sm btn-primary">Add Grade</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Grade Name</th>
                    <th>Range</th>
                    <th>Remark</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->grade_name }}</td>
                    <td>{{ $grade->min_percentage }}% - {{ $grade->max_percentage }}%</td>
                    <td>{{ $grade->remark }}</td>
                    <td>
                        <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
@endsection
