﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Admin Users</h1>
            <a href="{{ route('super-admin.admin-users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create New School Admin
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Email</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">School</th>
                            <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $u)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $u->name }}</td>
                                <td class="p-3 text-nowrap">{{ $u->email }}</td>
                                <td class="p-3 text-nowrap">{{ $u->phone_number }}</td>
                                <td class="p-3 text-nowrap">
                                    @if($u->school)
                                        <span class="badge bg-info text-white">{{ $u->school->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">No School</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('super-admin.admin-users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(auth()->id() !== $u->id)
                                            <form action="{{ route('super-admin.admin-users.destroy', $u->id) }}" method="POST" data-confirm-message="Are you sure you want to delete this admin and their school? This action cannot be undone." data-confirm-style="danger">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-secondary">No admin users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

