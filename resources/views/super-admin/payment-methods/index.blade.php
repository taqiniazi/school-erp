@extends('layouts.app')

@section('title', 'Payment Methods')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark">Payment Methods</h1>
        <a href="{{ route('super-admin.payment-methods.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Method
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
            <h6 class="m-0 fw-bold text-primary">All Payment Methods</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Instructions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($methods as $method)
                            <tr>
                                <td>{{ $method->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $method->type === 'gateway' ? 'info' : 'secondary' }}">
                                        {{ ucfirst($method->type) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($method->instructions, 50) }}</td>
                                <td>
                                    @if($method->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('super-admin.payment-methods.edit', $method) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('super-admin.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment method?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No payment methods found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $methods->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
