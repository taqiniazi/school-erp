﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Fee Types</h1>
            <a href="{{ route('fee-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Fee Type
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
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">ID</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Description</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeTypes as $type)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $type->id }}</td>
                                    <td class="p-3 text-nowrap fw-semibold">{{ $type->name }}</td>
                                    <td class="p-3">{{ $type->description }}</td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('fee-types.edit', $type->id) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                        <form action="{{ route('fee-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
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

