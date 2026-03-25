﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('My Leave Requests') }}</h1>
            <a href="{{ route('hr.leave.request.create') }}" class="btn btn-primary">New Request</a>
        </div>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-muted small">Year</div>
                                <div class="fw-bold">{{ $year ?? now()->format('Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-muted small">Paid Leaves</div>
                                <div class="fw-bold">{{ $usedPaid ?? 0 }} / {{ $totalPaid ?? 20 }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="text-muted small">Remaining</div>
                                <div class="fw-bold">{{ $remainingPaid ?? 0 }}</div>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Start</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">End</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Type</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Days</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $r)
                                    <tr>
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
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-3 text-center text-secondary">No requests found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



