﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Grade System</h1>
            <a href="{{ route('grades.create') }}" class="btn btn-primary">Add Grade</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Grade Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Range</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remark</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $grade->grade_name }}</td>
                                <td class="p-3 text-nowrap">{{ $grade->min_percentage }}% - {{ $grade->max_percentage }}%</td>
                                <td class="p-3 text-nowrap">{{ $grade->remark }}</td>
                                <td class="p-3 text-nowrap text-end">
                                    <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-secondary">No grades found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
