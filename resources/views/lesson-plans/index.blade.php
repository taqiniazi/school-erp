<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Lesson Plans</h1>
                <div class="text-muted">Create and manage lesson plans.</div>
            </div>
            <a href="{{ route('lesson-plans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Plan
            </a>
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

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('lesson-plans.index') }}" class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Class</label>
                        <select name="school_class_id" id="lp_school_class_id" class="form-select">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ (string) $schoolClassId === (string) $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Section</label>
                        <select name="section_id" id="lp_section_id" class="form-select">
                            <option value="">All Sections</option>
                            @foreach($sections as $sec)
                                <option value="{{ $sec->id }}" {{ (string) $sectionId === (string) $sec->id ? 'selected' : '' }}>
                                    {{ $sec->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Subject</label>
                        <select name="subject_id" class="form-select">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (string) $subjectId === (string) $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-outline-secondary">Filter</button>
                        <a href="{{ route('lesson-plans.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Topic</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teacher</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plans as $plan)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ optional($plan->planned_date)->format('Y-m-d') }}</td>
                                    <td class="p-3">{{ $plan->topic }}</td>
                                    <td class="p-3 text-nowrap">{{ $plan->schoolClass->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">{{ $plan->section->name ?? 'All' }}</td>
                                    <td class="p-3 text-nowrap">{{ $plan->subject->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">{{ $plan->teacher?->user?->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">
                                        @if($plan->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('lesson-plans.edit', $plan) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('lesson-plans.destroy', $plan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this lesson plan?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-3 text-center text-secondary">No lesson plans found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
