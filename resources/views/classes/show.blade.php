@extends('layouts.bootstrap')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Class: {{ $schoolClass->name }} ({{ $schoolClass->numeric_value }})</h1>
    <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="row">
    <!-- Sections Management -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sections</h5>
            </div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    @forelse($schoolClass->sections as $section)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $section->name }}
                        <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this section?')">Remove</button>
                        </form>
                    </li>
                    @empty
                    <li class="list-group-item text-center">No sections found.</li>
                    @endforelse
                </ul>

                <form action="{{ route('classes.sections.store', $schoolClass) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="New Section Name (e.g. A, B)" required>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Subjects Management -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Assigned Subjects</h5>
            </div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    @forelse($schoolClass->subjects as $subject)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $subject->name }}</strong> <span class="text-muted">({{ $subject->code }})</span>
                        </div>
                        <form action="{{ route('classes.subjects.destroy', ['schoolClass' => $schoolClass, 'subject' => $subject]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this subject from class?')">Remove</button>
                        </form>
                    </li>
                    @empty
                    <li class="list-group-item text-center">No subjects assigned.</li>
                    @endforelse
                </ul>

                <form action="{{ route('classes.subjects.store', $schoolClass) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <select name="subject_id" class="form-control" required>
                        <option value="">Select Subject</option>
                        @foreach($allSubjects as $subj)
                            @if(!$schoolClass->subjects->contains($subj->id))
                                <option value="{{ $subj->id }}">{{ $subj->name }} ({{ $subj->code }})</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
