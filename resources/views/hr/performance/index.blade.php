﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Performance Reviews') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <div></div>
                        <a href="{{ route('hr.performance.create') }}" class="btn btn-primary">New Review</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Staff</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Score</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $r)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $r->teacher->first_name }} {{ $r->teacher->last_name }}</td>
                                        <td class="p-3 text-nowrap">{{ $r->review_date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ number_format($r->score, 2) }}</td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('hr.performance.edit', $r) }}" class="btn btn-sm btn-success text-decoration-none">Edit</a>
                                            <form action="{{ route('hr.performance.destroy', $r) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-link text-danger text-decoration-none" onclick="return confirm('Delete review?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-3 text-center text-secondary">No reviews found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






