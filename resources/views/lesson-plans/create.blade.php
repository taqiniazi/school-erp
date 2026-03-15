<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Add Lesson Plan</h1>
                <div class="text-muted">Create a lesson plan for a class/subject.</div>
            </div>
            <a href="{{ route('lesson-plans.index') }}" class="btn btn-secondary">Back</a>
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
                <form action="{{ route('lesson-plans.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-12 col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="planned_date" value="{{ old('planned_date') }}" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Teacher (optional)</label>
                        <select name="teacher_id" class="form-select">
                            <option value="">Unassigned</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ (string) old('teacher_id') === (string) $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name ?? 'Teacher #' . $teacher->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Class</label>
                        <select name="school_class_id" id="lp_school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ (string) old('school_class_id') === (string) $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Section (optional)</label>
                        <select name="section_id" id="lp_section_id" class="form-select">
                            <option value="">All Sections</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Subject</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (string) old('subject_id') === (string) $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Topic</label>
                        <input type="text" name="topic" value="{{ old('topic') }}" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Objectives (optional)</label>
                        <textarea name="objectives" class="form-control" rows="3">{{ old('objectives') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Activities (optional)</label>
                        <textarea name="activities" class="form-control" rows="3">{{ old('activities') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Homework (optional)</label>
                        <textarea name="homework" class="form-control" rows="3">{{ old('homework') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Resources (optional)</label>
                        <textarea name="resources" class="form-control" rows="3">{{ old('resources') }}</textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('lesson-plans.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const classSelect = document.getElementById('lp_school_class_id');
                const sectionSelect = document.getElementById('lp_section_id');
                const oldSection = @json(old('section_id'));

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
                if (classSelect.value) loadSections(classSelect.value, oldSection);
            });
        </script>
    @endpush
</x-app-layout>

