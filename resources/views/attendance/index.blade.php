﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Attendance History</h1>
            <div class="btn-group">
                <a href="{{ route('attendance.report') }}" class="btn btn-info text-white">Monthly Report</a>
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">Take Attendance</a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('attendance.index') }}" method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="school_class_id" class="form-label">Class</label>
                        <select name="school_class_id" id="school_class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select name="section_id" id="section_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $selectedSection == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">Filter</button>
                    </div>
                </form>

                @if(count($attendances) > 0)
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Roll No</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Recorded By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $attendance->student->roll_number }}</td>
                                <td class="p-3 text-nowrap">{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
                                <td class="p-3 text-nowrap">
                                    <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : ($attendance->status === 'late' ? 'warning' : ($attendance->status === 'leave' ? 'primary' : 'info'))) }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $attendance->remarks }}</td>
                                <td class="p-3 text-nowrap">{{ $attendance->recordedBy->name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($selectedClass && $selectedSection)
                    <div class="alert alert-warning mb-0">
                        No attendance records found for this date.
                        <a href="{{ route('attendance.create', ['school_class_id' => $selectedClass, 'section_id' => $selectedSection, 'date' => $date]) }}" class="alert-link">Take Attendance Now</a>
                    </div>
                @else
                    <div class="alert alert-info mb-0">Select Class and Section to view attendance.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
