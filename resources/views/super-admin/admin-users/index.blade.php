@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Admin Users</h1>
        <a href="{{ route('super-admin.admin-users.create') }}" class="d-none d-sm-d-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New School Admin
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Existing School Admins</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>School</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone_number }}</td>
                                <td>
                                    @if($u->school)
                                        <span class="badge bg-info text-white">{{ $u->school->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">No School</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex g-2">
                                        <a href="{{ route('super-admin.admin-users.edit', $u->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(auth()->id() !== $u->id)
                                            <form action="{{ route('super-admin.admin-users.destroy', $u->id) }}" method="POST" data-confirm-message="Are you sure you want to delete this admin and their school? This action cannot be undone." data-confirm-style="danger">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No admin users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
</div>
@endsection



