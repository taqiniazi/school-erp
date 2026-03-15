<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Student Promotion</h1>
                <div class="text-muted">Move students from one class/section to another.</div>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('student-promotions.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-12">
                        <div class="fw-semibold mb-1">From</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Class</label>
                        <select name="from_school_class_id" id="from_school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('from_school_class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Section (optional)</label>
                        <select name="from_section_id" id="from_section_id" class="form-select">
                            <option value="">All Sections</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="fw-semibold mb-1">To</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Class</label>
                        <select name="to_school_class_id" id="to_school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('to_school_class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Section</label>
                        <select name="to_section_id" id="to_section_id" class="form-select" required>
                            <option value="">Select Section</option>
                        </select>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Promote students to the selected class/section?')">
                            Promote Students
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fromClass = document.getElementById('from_school_class_id');
                const toClass = document.getElementById('to_school_class_id');
                const fromSection = document.getElementById('from_section_id');
                const toSection = document.getElementById('to_section_id');

                const oldFromSection = @json(old('from_section_id'));
                const oldToSection = @json(old('to_section_id'));

                async function loadSections(classId, selectEl, { includeAll = false, selected = null } = {}) {
                    selectEl.innerHTML = includeAll
                        ? '<option value="">All Sections</option>'
                        : '<option value="">Select Section</option>';

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
                            selectEl.appendChild(opt);
                        });
                    } catch (e) {
                    }
                }

                fromClass.addEventListener('change', () => loadSections(fromClass.value, fromSection, { includeAll: true }));
                toClass.addEventListener('change', () => loadSections(toClass.value, toSection, { includeAll: false }));

                if (fromClass.value) loadSections(fromClass.value, fromSection, { includeAll: true, selected: oldFromSection });
                if (toClass.value) loadSections(toClass.value, toSection, { includeAll: false, selected: oldToSection });
            });
        </script>
    @endpush
</x-app-layout>
