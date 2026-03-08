<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Academic Reports') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    
                    <form method="GET" action="{{ route('reports.academic') }}" class="mb-4 row g-3">
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
                            <select id="section_id" name="section_id" class="form-select">
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Filter') }}
                            </button>
                        </div>
                    </form>

                    @if($students->isNotEmpty())
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
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Roll No</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Gender</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">DOB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $student->admission_number }}</td>
                                            <td class="p-3 text-nowrap small fw-medium text-dark">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $student->schoolClass->name ?? 'N/A' }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $student->section->name ?? 'N/A' }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $student->roll_number }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ ucfirst($student->gender) }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $student->dob }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">
                            <p class="mb-0">No students found. Please select a class to view report.</p>
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

        // Trigger change on load if value exists
        if (document.getElementById('school_class_id').value) {
            // Need to wait for fetch to complete before selecting section, or just rely on PHP rendering selected if possible?
            // The script above clears innerHTML, so PHP rendered options would be lost if I just trigger change.
            // Better to let the fetch happen.
             var classId = document.getElementById('school_class_id').value;
             var sectionSelect = document.getElementById('section_id');
             // sectionSelect.innerHTML = '<option value="">Select Section</option>'; // Don't clear if already populated by PHP? 
             // Actually, the view logic doesn't populate section options in PHP loop above (it's empty initially).
             // So I MUST trigger the fetch.
             
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



