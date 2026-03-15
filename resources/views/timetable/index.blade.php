<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Timetable</h1>
                <div class="text-muted">Manage class schedules.</div>
            </div>
            <a href="{{ route('timetable.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Entry
            </a>
        </div>
    </x-slot>

    @php
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];
    @endphp

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
                <form method="GET" action="{{ route('timetable.index') }}" class="row g-3 align-items-end">
                    <div class="col-12 col-md-5">
                        <label class="form-label">Class</label>
                        <select name="school_class_id" id="tt_school_class_id" class="form-select">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ (string) $schoolClassId === (string) $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label">Section</label>
                        <select name="section_id" id="tt_section_id" class="form-select">
                            <option value="">All Sections</option>
                            @foreach($sections as $sec)
                                <option value="{{ $sec->id }}" {{ (string) $sectionId === (string) $sec->id ? 'selected' : '' }}>
                                    {{ $sec->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex gap-2 justify-content-md-end">
                        <button type="submit" class="btn btn-outline-secondary">Filter</button>
                        <a href="{{ route('timetable.index') }}" class="btn btn-secondary">Reset</a>
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
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Day</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Time</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teacher</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Room</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entries as $entry)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $days[$entry->day_of_week] ?? $entry->day_of_week }}</td>
                                    <td class="p-3 text-nowrap">{{ substr((string) $entry->start_time, 0, 5) }} - {{ substr((string) $entry->end_time, 0, 5) }}</td>
                                    <td class="p-3 text-nowrap">{{ $entry->schoolClass->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">{{ $entry->section->name ?? 'All' }}</td>
                                    <td class="p-3 text-nowrap">{{ $entry->subject->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">{{ $entry->teacher?->user?->name ?? '' }}</td>
                                    <td class="p-3 text-nowrap">{{ $entry->room }}</td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('timetable.edit', $entry) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('timetable.destroy', $entry) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this entry?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-3 text-center text-secondary">No timetable entries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
