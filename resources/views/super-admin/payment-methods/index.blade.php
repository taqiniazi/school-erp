﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Payment Methods</h1>
            <a href="{{ route('super-admin.payment-methods.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Method
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
                <table class="table table-hover w-100 mb-0 align-middle" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Type</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Instructions</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                            <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($methods as $method)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $method->name }}</td>
                                <td class="p-3 text-nowrap">
                                    <span class="badge bg-{{ $method->type === 'gateway' ? 'info' : 'secondary' }}">
                                        {{ ucfirst($method->type) }}
                                    </span>
                                </td>
                                <td class="p-3">{{ Str::limit($method->instructions, 50) }}</td>
                                <td class="p-3 text-nowrap">
                                    @if($method->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    <a href="{{ route('super-admin.payment-methods.edit', $method) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('super-admin.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this payment method?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-secondary">No payment methods found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
