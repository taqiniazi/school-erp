﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Leave Requests') }}
        </h2>
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
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Staff</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Start</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">End</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Type</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Days</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $r)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $r->teacher->user->name ?? ($r->teacher->first_name.' '.$r->teacher->last_name) }}</td>
                                        <td class="p-3 text-nowrap">{{ $r->start_date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ $r->end_date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ ucfirst($r->type) }}</td>
                                        <td class="p-3 text-nowrap">
                                            @if(!is_null($r->total_days))
                                                {{ $r->total_days }}
                                                @if(!is_null($r->paid_days) || !is_null($r->unpaid_days))
                                                    <span class="text-muted small">({{ (int) ($r->paid_days ?? 0) }} paid, {{ (int) ($r->unpaid_days ?? 0) }} unpaid)</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap">
                                            @if($r->status === 'approved')
                                                <span class="badge rounded-pill text-bg-success">Approved</span>
                                            @elseif($r->status === 'rejected')
                                                <span class="badge rounded-pill text-bg-danger">Rejected</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap text-end">
                                            @if($r->status === 'pending')
                                                <form method="POST" class="d-inline-block text-start">
                                                    @csrf
                                                    <input type="text" name="remarks" class="form-control form-control-sm d-inline-block" style="width: 220px;" placeholder="Remarks (optional)">
                                                    <button formaction="{{ route('hr.leave.approve', $r) }}" class="btn btn-sm btn-link text-success text-decoration-none">Approve</button>
                                                    <button formaction="{{ route('hr.leave.reject', $r) }}" class="btn btn-sm btn-link text-danger text-decoration-none">Reject</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="p-3 text-center text-secondary">No leave requests found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





