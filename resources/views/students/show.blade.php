﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark  lh-sm">
            {{ __('Student Details') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container px-4">
            <div class="row g-4">
                <!-- Profile Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-dark d-flex flex-column align-items-center text-center">
                            @if($student->photo_path)
                                <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Student Photo" class="rounded-circle mb-4 border border-4 border-secondary object-fit-cover" style="width: 8rem; height: 8rem;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-4 text-white fw-bold display-4" style="width: 8rem; height: 8rem;">
                                    {{ substr($student->first_name, 0, 1) }}
                                </div>
                            @endif
                            
                            <h3 class="h4 fw-bold mb-1">{{ $student->first_name }} {{ $student->last_name }}</h3>
                            <p class="small text-secondary mb-4">{{ $student->admission_number }}</p>
                            
                            <span class="badge rounded-pill px-3 py-2 
                                {{ $student->status === 'active' ? 'bg-success-subtle text-success' : 
                                  ($student->status === 'graduated' ? 'bg-primary-subtle text-primary' : 
                                  'bg-danger-subtle text-danger') }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="col-md-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4 text-dark">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                                <h3 class="lead fw-medium m-0">Student Information</h3>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning text-white btn-sm fw-semibold">
                                    Edit
                                </a>
                            </div>

                            <div class="vstack gap-3">
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-medium text-secondary">Date of Birth:</div>
                                    <div class="col-md-8">{{ $student->dob }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-medium text-secondary">Gender:</div>
                                    <div class="col-md-8">{{ ucfirst($student->gender) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-medium text-secondary">Class & Section:</div>
                                    <div class="col-md-8">
                                        {{ $student->schoolClass->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-medium text-secondary">Admission Date:</div>
                                    <div class="col-md-8">{{ $student->admission_date }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-medium text-secondary">Address:</div>
                                    <div class="col-md-8">{{ $student->address }}</div>
                                </div>
                                <div class="row mb-2 border-top pt-3 mt-2">
                                    <div class="col-md-4 fw-medium text-secondary">Parents/Guardians:</div>
                                    <div class="col-md-8">
                                        @if($student->parents && $student->parents->count() > 0)
                                            @foreach($student->parents as $parent)
                                                <div class="mb-2">
                                                    <span class="fw-semibold">{{ $parent->user->name }}</span> 
                                                    <span class="small text-secondary">({{ $parent->pivot->relation }})</span>
                                                    <div class="small text-secondary">{{ $parent->user->email }}</div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-secondary fst-italic">No parents linked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



