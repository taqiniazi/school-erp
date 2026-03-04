@extends('layouts.bootstrap')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Classes</h1>
    <a href="{{ route('classes.create') }}" class="btn btn-primary">Add Class</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Numeric Value</th>
                    <th>Name</th>
                    <th>Sections</th>
                    <th>Subjects</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                <tr>
                    <td>{{ $class->numeric_value }}</td>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->sections->count() }}</td>
                    <td>{{ $class->subjects->count() }}</td>
                    <td>
                        <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-info">Manage</a>
                        <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this class?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No classes found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
