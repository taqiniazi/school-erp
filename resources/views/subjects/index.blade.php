﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Subjects</h1>
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add Subject</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Code</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Type</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $subject->code }}</td>
                                <td class="p-3 text-nowrap">{{ $subject->name }}</td>
                                <td class="p-3 text-nowrap">{{ ucfirst($subject->type) }}</td>
                                <td class="p-3 text-nowrap text-end">
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this subject?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-secondary">No subjects found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
