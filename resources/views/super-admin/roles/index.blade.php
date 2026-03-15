﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Role Management</h1>
            <a href="{{ route('super-admin.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create Role
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Guard</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Permissions</th>
                            <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $role->name }}</td>
                                <td class="p-3 text-nowrap">{{ $role->guard_name }}</td>
                                <td class="p-3">
                                    @foreach($role->permissions->take(5) as $permission)
                                        <span class="badge bg-secondary">{{ $permission->name }}</span>
                                    @endforeach
                                    @if($role->permissions->count() > 5)
                                        <span class="badge bg-light text-dark">+{{ $role->permissions->count() - 5 }} more</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('super-admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @if(!in_array($role->name, ['Super Admin', 'School Admin', 'Teacher', 'Student', 'Parent']))
                                            <form action="{{ route('super-admin.roles.destroy', $role->id) }}" method="POST" data-confirm-message="Are you sure you want to delete this role?" data-confirm-style="danger">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-secondary">No roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

