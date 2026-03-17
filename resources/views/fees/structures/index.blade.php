﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Fee Structures</h1>
            <a href="{{ route('fee-structures.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Fee Structure
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

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Fee Type</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Amount</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Frequency</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Academic Year</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeStructures as $structure)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $structure->schoolClass->name }}</td>
                                    <td class="p-3 text-nowrap">{{ $structure->feeType->name }}</td>
                                    <td class="p-3 text-nowrap text-end">{{ $structure->amount }}</td>
                                    <td class="p-3 text-nowrap">
                                        @if($structure->frequency == 1) Monthly
                                        @elseif($structure->frequency == 2) Quarterly
                                        @elseif($structure->frequency == 3) Annually
                                        @else One-time
                                        @endif
                                    </td>
                                    <td class="p-3 text-nowrap">{{ $structure->academic_year }}</td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('fee-structures.edit', $structure->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('fee-structures.destroy', $structure->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

