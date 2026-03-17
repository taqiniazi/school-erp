﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Take Attendance</h1>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">View History</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('attendance.create') }}" method="GET" class="row g-3 mb-4">
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
                        <button type="submit" class="btn btn-primary w-100">Load Students</button>
                    </div>
                </form>

                @if(count($students) > 0)
                @php
                    $isTeacher = auth()->check() && auth()->user()->hasRole('Teacher');
                @endphp
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="school_class_id" value="{{ $selectedClass }}">
                    <input type="hidden" name="section_id" value="{{ $selectedSection }}">
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="mb-0">Students ({{ count($students) }})</h5>
                        @if($isTeacher)
                            <div class="btn-group btn-group-sm" role="group" aria-label="Bulk attendance">
                                <button type="button" class="btn btn-outline-success" onclick="setAllPresent(true)">All Present</button>
                                <button type="button" class="btn btn-outline-danger" onclick="setAllPresent(false)">All Absent</button>
                            </div>
                        @else
                            <div class="btn-group btn-group-sm" role="group" aria-label="Bulk attendance">
                                <button type="button" class="btn btn-outline-success" onclick="markAll('present')">All Present</button>
                                <button type="button" class="btn btn-outline-danger" onclick="markAll('absent')">All Absent</button>
                                <button type="button" class="btn btn-outline-warning" onclick="markAll('late')">All Late</button>
                                <button type="button" class="btn btn-outline-primary" onclick="markAll('leave')">All Leave</button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Roll No</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    @if($isTeacher)
                                        <th class="p-3 text-center small fw-medium text-secondary text-uppercase" style="min-width: 120px;">Present</th>
                                    @else
                                        <th class="p-3 text-center small fw-medium text-secondary text-uppercase" style="min-width: 200px;">Status</th>
                                    @endif
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    @php
                                        $status = $existingAttendance[$student->id]->status ?? ($isTeacher ? 'absent' : 'present');
                                        $remarks = $existingAttendance[$student->id]->remarks ?? '';
                                        $locked = ! in_array($status, ['present', 'absent'], true);
                                    @endphp
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $student->roll_number }}</td>
                                    <td class="p-3 text-nowrap">{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td class="p-3 text-center">
                                        <input type="hidden" name="attendances[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                        @if($isTeacher)
                                            <input type="hidden" id="status_input_{{ $student->id }}" name="attendances[{{ $student->id }}][status]" value="{{ $status }}">
                                            @if($locked)
                                                <span class="badge rounded-pill text-bg-secondary">{{ strtoupper(str_replace('_', ' ', (string) $status)) }}</span>
                                            @else
                                                <div class="form-check form-switch d-inline-flex align-items-center justify-content-center m-0">
                                                    <input class="form-check-input js-present-toggle" type="checkbox" role="switch" id="present_{{ $student->id }}" data-status-input="status_input_{{ $student->id }}" {{ $status === 'present' ? 'checked' : '' }}>
                                                </div>
                                            @endif
                                        @else
                                            <div class="btn-group" role="group">
                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_p_{{ $student->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }} required>
                                                <label class="btn btn-outline-success" for="status_p_{{ $student->id }}">P</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_a_{{ $student->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="status_a_{{ $student->id }}">A</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_l_{{ $student->id }}" value="late" {{ $status == 'late' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning" for="status_l_{{ $student->id }}">L</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_lv_{{ $student->id }}" value="leave" {{ $status == 'leave' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-primary" for="status_lv_{{ $student->id }}">LV</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="status_h_{{ $student->id }}" value="half_day" {{ $status == 'half_day' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-info" for="status_h_{{ $student->id }}">HD</label>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <input type="text" name="attendances[{{ $student->id }}][remarks]" class="form-control form-control-sm" value="{{ $remarks }}" placeholder="Optional">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-row g-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Save Attendance</button>
                    </div>
                </form>
                @elseif($selectedClass && $selectedSection)
                    <div class="alert alert-info mb-0">No students found in this class/section.</div>
                @endif
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

    function setAllPresent(isPresent) {
        const toggles = document.querySelectorAll('.js-present-toggle');
        toggles.forEach((toggle) => {
            toggle.checked = isPresent;
            const targetId = toggle.getAttribute('data-status-input');
            const input = targetId ? document.getElementById(targetId) : null;
            if (input) {
                input.value = isPresent ? 'present' : 'absent';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.js-present-toggle').forEach((toggle) => {
            toggle.addEventListener('change', () => {
                const targetId = toggle.getAttribute('data-status-input');
                const input = targetId ? document.getElementById(targetId) : null;
                if (input) {
                    input.value = toggle.checked ? 'present' : 'absent';
                }
            });
        });
    });
</script>
@endpush
</x-app-layout>
