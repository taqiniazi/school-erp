﻿@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark">Plans Management</h1>
        <a href="{{ route('super-admin.plans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Plan
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
            <h6 class="m-0 fw-bold">All Subscription Plans</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-100" id="plansTable">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Price</th>
                            <th>Billing Cycle</th>
                            <th>Limits (Stu/Tch/Cam)</th>
                            <th>Storage</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td><code>{{ $plan->code }}</code></td>
                                <td>${{ number_format($plan->price, 2) }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($plan->billing_cycle) }}</span></td>
                                <td>
                                    {{ $plan->max_students ?? 'âˆž' }} / 
                                    {{ $plan->max_teachers ?? 'âˆž' }} / 
                                    {{ $plan->max_campuses ?? 'âˆž' }}
                                </td>
                                <td>{{ $plan->storage_limit_mb ? $plan->storage_limit_mb . ' MB' : 'Unlimited' }}</td>
                                <td>
                                    @if($plan->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('super-admin.plans.edit', $plan) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('super-admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?');" style="display: d-inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No plans found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $plans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection



