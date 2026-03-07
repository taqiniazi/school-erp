@extends('layouts.bootstrap')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Teacher Allocations</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAllocationModal">
        Assign Teacher
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allocations as $allocation)
                    <tr>
                        <td>{{ $allocation->teacher->user->name ?? 'N/A' }}</td>
                        <td>{{ $allocation->schoolClass->name ?? 'N/A' }}</td>
                        <td>{{ $allocation->section->name ?? 'All' }}</td>
                        <td>{{ $allocation->subject->name ?? 'N/A' }} ({{ $allocation->subject->code ?? '' }})</td>
                        <td>
                            <form action="{{ route('allocations.destroy', $allocation) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this allocation?')">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No allocations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $allocations->links() }}
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createAllocationModal" tabindex="-1" aria-labelledby="createAllocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('allocations.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAllocationModalLabel">Assign Teacher to Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-select" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'Unknown' }} ({{ $teacher->employee_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="school_class_id" class="form-label">Class</label>
                        <select name="school_class_id" id="school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select name="section_id" id="section_id" class="form-select" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }} (Class: {{ $section->schoolClass->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
