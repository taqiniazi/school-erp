﻿<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">Fee Structures</h2>
            <a href="{{ route('fee-structures.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Fee Structure
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Manage Fee Structures</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Class</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Frequency</th>
                                <th>Academic Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeStructures as $structure)
                                <tr>
                                    <td>{{ $structure->schoolClass->name }}</td>
                                    <td>{{ $structure->feeType->name }}</td>
                                    <td>{{ $structure->amount }}</td>
                                    <td>
                                        @if($structure->frequency == 1) Monthly
                                        @elseif($structure->frequency == 2) Quarterly
                                        @elseif($structure->frequency == 3) Annually
                                        @else One-time
                                        @endif
                                    </td>
                                    <td>{{ $structure->academic_year }}</td>
                                    <td>
                                        <a href="{{ route('fee-structures.edit', $structure->id) }}" class="btn btn-sm btn-primary me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('fee-structures.destroy', $structure->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
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


