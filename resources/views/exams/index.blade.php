﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Exams List</h1>
            <a href="{{ route('exams.create') }}" class="btn btn-primary">Create Exam</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Session</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Start Date</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">End Date</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exams as $exam)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $exam->name }}</td>
                                <td class="p-3 text-nowrap">{{ $exam->session_year }}</td>
                                <td class="p-3 text-nowrap">{{ $exam->start_date->format('Y-m-d') }}</td>
                                <td class="p-3 text-nowrap">{{ $exam->end_date->format('Y-m-d') }}</td>
                                <td class="p-3 text-nowrap">
                                    @if($exam->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    <a href="{{ route('exams.schedules', $exam) }}" class="btn btn-sm btn-outline-info">Schedule</a>
                                    <a href="{{ route('exams.edit', $exam) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    
                                    @if($exam->is_published)
                                        <form action="{{ route('exams.unpublish', $exam) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Unpublish</button>
                                        </form>
                                    @else
                                        <form action="{{ route('exams.publish', $exam) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">Publish</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-secondary">No exams found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
