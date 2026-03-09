@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Role Management</h1>
        <a href="{{ route('super-admin.roles.create') }}" class="d-none d-sm-d-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create Role
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">System Roles</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Guard</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    @foreach($role->permissions->take(5) as $permission)
                                        <span class="badge bg-secondary">{{ $permission->name }}</span>
                                    @endforeach
                                    @if($role->permissions->count() > 5)
                                        <span class="badge bg-light text-dark">+{{ $role->permissions->count() - 5 }} more</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex g-2">
                                        <a href="{{ route('super-admin.roles.edit', $role->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                        @if(!in_array($role->name, ['Super Admin', 'School Admin', 'Teacher', 'Student', 'Parent']))
                                            <form action="{{ route('super-admin.roles.destroy', $role->id) }}" method="POST" data-confirm-message="Are you sure you want to delete this role?" data-confirm-style="danger">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection



