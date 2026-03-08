@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Subscriptions</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Manage Subscriptions</h6>
        </div>
        <div class="card-body">
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
                <table class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>School</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $subscription->school->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $subscription->school->email ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $subscription->plan->name ?? 'N/A' }}</td>
                                <td>
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
                                <td>{{ $subscription->current_period_start ? $subscription->current_period_start->format('Y-m-d') : '-' }}</td>
                                <td>{{ $subscription->current_period_end ? $subscription->current_period_end->format('Y-m-d') : '-' }}</td>
                                <td>
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
                                <td colspan="6" class="text-center">No subscriptions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
