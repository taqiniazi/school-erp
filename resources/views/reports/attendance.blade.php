﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Attendance Reports') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    
                    <form method="GET" action="{{ route('reports.attendance') }}" class="mb-4 row g-3">
                        <div class="col-md-3">
                            <label for="school_class_id" class="form-label">{{ __('Class') }}</label>
                            <select id="school_class_id" name="school_class_id" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="section_id" class="form-label">{{ __('Section') }}</label>
                            <select id="section_id" name="section_id" class="form-select" required>
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="month" class="form-label">{{ __('Month') }}</label>
                            <select id="month" name="month" class="form-select" required>
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="year" class="form-label">{{ __('Year') }}</label>
                            <select id="year" name="year" class="form-select" required>
                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Filter') }}
                            </button>
                        </div>
                    </form>

                    @if($attendances->isNotEmpty())
                        <div class="mb-4 d-flex gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-danger text-white">
                                Export PDF
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="btn btn-success text-white">
                                Export Excel
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover w-100 mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Admission No</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Present</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Absent</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Late</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $record)
                                        <tr>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $record['student']->admission_number }}</td>
                                            <td class="p-3 text-nowrap small fw-medium text-dark">{{ $record['student']->first_name }} {{ $record['student']->last_name }}</td>
                                            <td class="p-3 text-nowrap small text-success">{{ $record['present'] }}</td>
                                            <td class="p-3 text-nowrap small text-danger">{{ $record['absent'] }}</td>
                                            <td class="p-3 text-nowrap small text-warning">{{ $record['late'] }}</td>
                                            <td class="p-3 text-nowrap small fw-bold text-dark">{{ $record['percentage'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">
                            <p class="mb-0">No attendance records found for the selected criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('school_class_id').addEventListener('change', function() {
            var classId = this.value;
            var sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (classId) {
                fetch(`/classes/${classId}/sections`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(section => {
                            var option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            if (section.id == "{{ request('section_id') }}") {
                                option.selected = true;
                            }
                            sectionSelect.appendChild(option);
                        });
                    });
            }
        });

        if (document.getElementById('school_class_id').value) {
            var classId = document.getElementById('school_class_id').value;
            var sectionSelect = document.getElementById('section_id');
            
            fetch(`/classes/${classId}/sections`)
                .then(response => response.json())
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    data.forEach(section => {
                        var option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.name;
                        if (section.id == "{{ request('section_id') }}") {
                            option.selected = true;
                        }
                        sectionSelect.appendChild(option);
                    });
                });
        }
    </script>
</x-app-layout>



