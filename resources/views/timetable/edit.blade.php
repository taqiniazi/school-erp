<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Edit Timetable Entry</h1>
                <div class="text-muted">Update schedule slot.</div>
            </div>
            <a href="{{ route('timetable.index', ['school_class_id' => $entry->school_class_id, 'section_id' => $entry->section_id]) }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('timetable.update', $entry) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-12 col-md-6">
                        <label class="form-label">Class</label>
                        <select name="school_class_id" id="tt_school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ (string) old('school_class_id', $entry->school_class_id) === (string) $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Section (optional)</label>
                        <select name="section_id" id="tt_section_id" class="form-select">
                            <option value="">All Sections</option>
                            @foreach($sections as $sec)
                                <option value="{{ $sec->id }}" {{ (string) old('section_id', $entry->section_id) === (string) $sec->id ? 'selected' : '' }}>
                                    {{ $sec->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Subject</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (string) old('subject_id', $entry->subject_id) === (string) $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Teacher (optional)</label>
                        <select name="teacher_id" class="form-select">
                            <option value="">Unassigned</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ (string) old('teacher_id', $entry->teacher_id) === (string) $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name ?? 'Teacher #' . $teacher->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label">Day</label>
                        <select name="day_of_week" class="form-select" required>
                            <option value="">Select Day</option>
                            <option value="1" {{ old('day_of_week', $entry->day_of_week) == 1 ? 'selected' : '' }}>Monday</option>
                            <option value="2" {{ old('day_of_week', $entry->day_of_week) == 2 ? 'selected' : '' }}>Tuesday</option>
                            <option value="3" {{ old('day_of_week', $entry->day_of_week) == 3 ? 'selected' : '' }}>Wednesday</option>
                            <option value="4" {{ old('day_of_week', $entry->day_of_week) == 4 ? 'selected' : '' }}>Thursday</option>
                            <option value="5" {{ old('day_of_week', $entry->day_of_week) == 5 ? 'selected' : '' }}>Friday</option>
                            <option value="6" {{ old('day_of_week', $entry->day_of_week) == 6 ? 'selected' : '' }}>Saturday</option>
                            <option value="7" {{ old('day_of_week', $entry->day_of_week) == 7 ? 'selected' : '' }}>Sunday</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time', substr((string) $entry->start_time, 0, 5)) }}" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time', substr((string) $entry->end_time, 0, 5)) }}" class="form-control" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Room (optional)</label>
                        <input type="text" name="room" value="{{ old('room', $entry->room) }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Note (optional)</label>
                        <input type="text" name="note" value="{{ old('note', $entry->note) }}" class="form-control">
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('timetable.index', ['school_class_id' => $entry->school_class_id, 'section_id' => $entry->section_id]) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const classSelect = document.getElementById('tt_school_class_id');
                const sectionSelect = document.getElementById('tt_section_id');
                const oldSection = @json(old('section_id', $entry->section_id));

                async function loadSections(classId, selected = null) {
                    sectionSelect.innerHTML = '<option value="">All Sections</option>';
                    if (!classId) return;

                    try {
                        const res = await fetch(`/classes/${classId}/sections`);
                        if (!res.ok) return;
                        const items = await res.json();
                        items.forEach((s) => {
                            const opt = document.createElement('option');
                            opt.value = s.id;
                            opt.textContent = s.name;
                            if (selected && String(selected) === String(s.id)) opt.selected = true;
                            sectionSelect.appendChild(opt);
                        });
                    } catch (e) {
                    }
                }

                classSelect.addEventListener('change', () => loadSections(classSelect.value));
                loadSections(classSelect.value, oldSection);
            });
        </script>
    @endpush
</x-app-layout>

