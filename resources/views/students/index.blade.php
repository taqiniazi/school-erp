@extends('layouts.bootstrap')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Students</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Admission No</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>{{ $student->admission_number }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->schoolClass->name }}</td>
                        <td>{{ $student->section->name }}</td>
                        <td>
                            @foreach($student->parents as $parent)
                                {{ $parent->name }} ({{ $parent->pivot->relation }})<br>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge bg-{{ $student->status === 'active' ? 'success' : ($student->status === 'graduated' ? 'info' : 'danger') }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No students found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $students->links() }}
    </div>
</div>
@endsection
