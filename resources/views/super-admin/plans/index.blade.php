﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Plans Management</h1>
            <a href="{{ route('super-admin.plans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Plan
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
                <table class="table table-hover w-100 mb-0 align-middle" id="plansTable">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Code</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Price</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Billing Cycle</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Limits (Stu/Tch/Cam)</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Storage</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                            <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $plan->name }}</td>
                                <td class="p-3 text-nowrap"><code>{{ $plan->code }}</code></td>
                                <td class="p-3 text-nowrap">${{ number_format($plan->price, 2) }}</td>
                                <td class="p-3 text-nowrap"><span class="badge bg-info">{{ ucfirst($plan->billing_cycle) }}</span></td>
                                <td>
                                    {!! $plan->max_students ?? '&#8734;' !!} /
                                    {!! $plan->max_teachers ?? '&#8734;' !!} /
                                    {!! $plan->max_campuses ?? '&#8734;' !!}
                                </td>
                                <td class="p-3 text-nowrap">{{ $plan->storage_limit_mb ? $plan->storage_limit_mb . ' MB' : 'Unlimited' }}</td>
                                <td class="p-3 text-nowrap">
                                    @if($plan->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('super-admin.plans.edit', $plan) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('super-admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?');" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-3 text-center text-secondary">No plans found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
