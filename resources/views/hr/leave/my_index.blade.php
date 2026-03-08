<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('My Leave Requests') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <div></div>
                        <a href="{{ route('hr.leave.create') }}" class="btn btn-primary">New Request</a>
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
                                    <tr><td colspan="4" class="p-3 text-center text-secondary">No requests found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






