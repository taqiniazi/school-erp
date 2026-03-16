<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('Suppliers') }}</h1>
            <a href="{{ route('inventory.suppliers.create') }}" class="btn btn-primary">New Supplier</a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Contact</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Email</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td class="p-3 fw-semibold text-nowrap">{{ $supplier->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $supplier->contact_person ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">{{ $supplier->phone ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">{{ $supplier->email ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">
                                            @if ($supplier->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('inventory.suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('inventory.suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete supplier?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-3 text-center text-secondary">No suppliers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
