<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Student Leave Approvals</h1>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-group input-group-sm" style="width: 290px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" placeholder="Search requests..." aria-label="Search leave approvals" data-dt-target="studentLeaveApprovalsTable">
                </div>
                <div class="btn-group">
                <a href="{{ route('student-leaves.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('student-leaves.index', ['status' => 'approved']) }}" class="btn btn-outline-success {{ $status === 'approved' ? 'active' : '' }}">Approved</a>
                <a href="{{ route('student-leaves.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger {{ $status === 'rejected' ? 'active' : '' }}">Rejected</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if(!empty($tableMissing) && $tableMissing)
                    <div class="alert alert-warning mb-4" role="alert">
                        Student leave approvals are not available yet because the database table/schema is missing. Run <code>php artisan migrate</code>.
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="studentLeaveApprovalsTable" class="table table-hover w-100 mb-0" data-dt-dom="rt&lt;'d-flex justify-content-between align-items-center pt-3'ip&gt;" data-dt-length-change="false">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Dates</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Requested By</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Reason</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $r)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $r->student->first_name }} {{ $r->student->last_name }}</td>
                                    <td class="p-3 text-nowrap">{{ $r->student->schoolClass->name ?? 'N/A' }} - {{ $r->student->section->name ?? 'N/A' }}</td>
                                    <td class="p-3 text-nowrap">{{ $r->start_date->format('Y-m-d') }} → {{ $r->end_date->format('Y-m-d') }}</td>
                                    <td class="p-3 text-nowrap">{{ $r->requester->name ?? 'N/A' }}</td>
                                    <td class="p-3" style="max-width: 420px;">
                                        <div class="text-truncate">{{ $r->reason }}</div>
                                        @if($r->attachment_path)
                                            <div class="mt-1">
                                                <a class="small text-decoration-none" href="{{ asset('storage/' . $r->attachment_path) }}" target="_blank" rel="noopener">View attachment</a>
                                            </div>
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
                                            <form method="POST" class="d-inline-flex align-items-center justify-content-end gap-2 flex-wrap">
                                                @csrf
                                                <input type="text" name="remarks" class="form-control form-control-sm" style="width: 220px;" placeholder="Remarks (optional)">
                                                <button formaction="{{ route('student-leaves.approve', $r) }}" class="btn btn-sm btn-success">Approve</button>
                                                <button formaction="{{ route('student-leaves.reject', $r) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Reject this request?');">Reject</button>
                                            </form>
                                        @else
                                            <span class="text-muted small">{{ $r->remarks ?: '—' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="p-3 text-center text-secondary">No requests found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
