@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($student->photo_path)
                    <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Student Photo" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-inline-block mb-3" style="width: 150px; height: 150px; line-height: 150px; color: white; font-size: 50px;">
                        {{ substr($student->first_name, 0, 1) }}
                    </div>
                @endif
                <h4>{{ $student->first_name }} {{ $student->last_name }}</h4>
                <p class="text-muted">{{ $student->admission_number }}</p>
                <div class="badge bg-{{ $student->status === 'active' ? 'success' : ($student->status === 'graduated' ? 'info' : 'danger') }}">
                    {{ ucfirst($student->status) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Student Details
                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning float-end">Edit</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Date of Birth:</div>
                    <div class="col-md-8">{{ $student->dob }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Gender:</div>
                    <div class="col-md-8">{{ ucfirst($student->gender) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Class & Section:</div>
                    <div class="col-md-8">{{ $student->schoolClass->name }} - {{ $student->section->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Admission Date:</div>
                    <div class="col-md-8">{{ $student->admission_date }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Address:</div>
                    <div class="col-md-8">{{ $student->address }}</div>
                </div>
                 <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Parents/Guardians:</div>
                    <div class="col-md-8">
                        @foreach($student->parents as $parent)
                            <p class="mb-1">{{ $parent->name }} ({{ $parent->pivot->relation }}) - {{ $parent->email }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
