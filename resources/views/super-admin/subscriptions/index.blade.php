﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Subscriptions</h1>
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

            <form action="{{ route('super-admin.subscriptions.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search School or Email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="trialing" {{ request('status') == 'trialing' ? 'selected' : '' }}>Trialing</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">School</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Plan</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Start Date</th>
                            <th class="p-3 text-start small fw-medium text-secondary text-uppercase">End Date</th>
                            <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td class="p-3">
                                    <div class="fw-bold">{{ $subscription->school->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $subscription->school->email ?? 'N/A' }}</small>
                                </td>
                                <td class="p-3 text-nowrap">{{ $subscription->plan->name ?? 'N/A' }}</td>
                                <td class="p-3 text-nowrap">
                                    @if($subscription->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($subscription->status === 'trialing')
                                        <span class="badge bg-info text-dark">Trialing</span>
                                    @elseif($subscription->status === 'canceled')
                                        <span class="badge bg-danger">Canceled</span>
                                    @elseif($subscription->status === 'pending_approval')
                                        <span class="badge bg-warning text-dark">Pending Approval</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap">{{ $subscription->current_period_start ? $subscription->current_period_start->format('Y-m-d') : '-' }}</td>
                                <td class="p-3 text-nowrap">{{ $subscription->current_period_end ? $subscription->current_period_end->format('Y-m-d') : '-' }}</td>
                                <td class="p-3 text-nowrap text-end">
                                    <div class="btn-group" role="group">
                                        @if(in_array($subscription->status, ['active', 'trialing']))
                                            <form action="{{ route('super-admin.subscriptions.cancel', $subscription->id) }}" method="POST" data-confirm-message="Are you sure you want to cancel this subscription?" data-confirm-style="danger">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                            </form>
                                        @else
                                            <form action="{{ route('super-admin.subscriptions.activate', $subscription->id) }}" method="POST" data-confirm-message="Are you sure you want to activate this subscription?">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-secondary">No subscriptions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
