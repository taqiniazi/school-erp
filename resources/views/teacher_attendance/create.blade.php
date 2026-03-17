﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Take Teacher Attendance</h1>
            <a href="{{ route('teacher-attendance.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('teacher-attendance.create') }}" method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                </form>

                <form action="{{ route('teacher-attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="mb-3 d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="markAll('present')">Mark All Present</button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="markAll('absent')">Mark All Absent</button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="markAll('holiday')">Mark All Holiday</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teacher Name</th>
                                    <th class="p-3 text-center small fw-medium text-secondary text-uppercase" style="width: 350px;">Status</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                    @php
                                        $status = $existingAttendance[$teacher->id]->status ?? 'present';
                                        $remarks = $existingAttendance[$teacher->id]->remarks ?? '';
                                    @endphp
                                    <tr>
                                        <td class="p-3 text-nowrap">
                                            {{ $teacher->name }}
                                            <input type="hidden" name="attendances[{{ $teacher->id }}][teacher_id]" value="{{ $teacher->id }}">
                                        </td>
                                        <td class="p-3 text-center">
                                            <div class="btn-group" role="group">
                                                <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_p_{{ $teacher->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }} required>
                                                <label class="btn btn-outline-success" for="status_p_{{ $teacher->id }}">P</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_a_{{ $teacher->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="status_a_{{ $teacher->id }}">A</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_l_{{ $teacher->id }}" value="late" {{ $status == 'late' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning" for="status_l_{{ $teacher->id }}">L</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_h_{{ $teacher->id }}" value="half_day" {{ $status == 'half_day' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-info" for="status_h_{{ $teacher->id }}">HD</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_hol_{{ $teacher->id }}" value="holiday" {{ $status == 'holiday' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-secondary" for="status_hol_{{ $teacher->id }}">H</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $teacher->id }}][status]" id="status_lev_{{ $teacher->id }}" value="leave" {{ $status == 'leave' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-primary" for="status_lev_{{ $teacher->id }}">LV</label>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <input type="text" name="attendances[{{ $teacher->id }}][remarks]" class="form-control form-control-sm" placeholder="Remarks" value="{{ $remarks }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Save Attendance</button>
                </form>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    function markAll(status) {
        document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endpush
</x-app-layout>
