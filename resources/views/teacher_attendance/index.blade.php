﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Teacher Attendance History</h1>
            <div class="btn-group">
                <a href="{{ route('teacher-attendance.report') }}" class="btn btn-info text-white">Monthly Report</a>
                <a href="{{ route('teacher-attendance.create') }}" class="btn btn-primary">Take Attendance</a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('teacher-attendance.index') }}" method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                </form>

                @if($attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teacher Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $attendance->teacher->name }}</td>
                                        <td class="p-3 text-nowrap">
                                            <span class="badge bg-{{ $attendance->status == 'present' ? 'success' : ($attendance->status == 'absent' ? 'danger' : 'warning') }}">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </td>
                                        <td class="p-3">{{ $attendance->remarks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">No attendance records found for this date.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
