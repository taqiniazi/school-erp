﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">My Attendance</h1>
            <span class="text-muted fw-semibold">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->roll_number }})</span>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('student.my-attendance') }}" method="GET" class="row g-3 mb-4">
            @if(isset($children) && $children->count() > 1)
                <div class="col-md-3">
                    <label for="student_id" class="form-label">Select Child</label>
                    <select name="student_id" id="student_id" class="form-select" onchange="this.form.submit()">
                        @foreach($children as $child)
                            <option value="{{ $child->id }}" {{ $student->id == $child->id ? 'selected' : '' }}>
                                {{ $child->first_name }} {{ $child->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-3">
                <label for="month" class="form-label">Month</label>
                <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label">Year</label>
                <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                    @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </form>

        <div class="row">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= $daysInMonth; $i++)
                                @php
                                    $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                                    $record = $attendances[$date] ?? null;
                                    $status = $record ? $record->status : '-';
                                    $color = match($status) {
                                        'present' => 'text-success fw-bold',
                                        'absent' => 'text-danger fw-bold',
                                        'late' => 'text-warning fw-bold',
                                        'half_day' => 'text-info fw-bold',
                                        'holiday' => 'text-secondary fw-bold',
                                        'leave' => 'text-primary fw-bold',
                                        default => 'text-muted'
                                    };
                                @endphp
                                <tr>
                                    <td class="p-3 text-nowrap">{{ date('d-m-Y (D)', strtotime($date)) }}</td>
                                    <td class="p-3 text-nowrap {{ $color }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                                    <td class="p-3">{{ $record ? $record->remarks : '' }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom">Summary</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Present
                            <span class="badge bg-success rounded-pill">{{ $attendances->where('status', 'present')->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Absent
                            <span class="badge bg-danger rounded-pill">{{ $attendances->where('status', 'absent')->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Late
                            <span class="badge bg-warning rounded-pill">{{ $attendances->where('status', 'late')->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Working Days
                            <span class="badge bg-secondary rounded-pill">{{ $attendances->whereIn('status', ['present', 'late', 'half_day'])->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</x-app-layout>

