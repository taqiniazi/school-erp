<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Student Leave Requests</h1>
            <a href="{{ route('parent.leaves.create') }}" class="btn btn-primary">New Request</a>
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
                        Student leave requests are not available yet because the database table/schema is missing. Run <code>php artisan migrate</code>.
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                    <form action="{{ route('parent.leaves.index') }}" method="GET" class="d-flex align-items-end gap-2 flex-wrap">
                        <div style="min-width: 240px;">
                            <label class="form-label mb-1">Child</label>
                            <select name="student_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All</option>
                            @foreach($children as $child)
                                <option value="{{ $child->id }}" {{ (string) $studentId === (string) $child->id ? 'selected' : '' }}>
                                    {{ $child->first_name }} {{ $child->last_name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </form>

                    <div class="input-group input-group-sm" style="width: 290px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search requests..." aria-label="Search leave requests" data-dt-target="parentLeaveRequestsTable">
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="parentLeaveRequestsTable" class="table table-hover w-100 mb-0" data-dt-dom="rt&lt;'d-flex justify-content-between align-items-center pt-3'ip&gt;" data-dt-length-change="false">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Child</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Dates</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Reason</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Remarks</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $r)
                                <tr>
                                    <td class="p-3 text-nowrap">{{ $r->student->first_name }} {{ $r->student->last_name }}</td>
                                    <td class="p-3 text-nowrap">
                                        <div class="fw-medium">{{ $r->start_date->format('Y-m-d') }} → {{ $r->end_date->format('Y-m-d') }}</div>
                                    </td>
                                    <td class="p-3" style="max-width: 420px;">
                                        <div class="text-truncate">{{ $r->reason }}</div>
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
                                    <td class="p-3">
                                        <span class="text-muted small">{{ $r->remarks ?: '—' }}</span>
                                    </td>
                                    <td class="p-3 text-end text-nowrap">
                                        @if($r->attachment_path)
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ asset('storage/' . $r->attachment_path) }}" target="_blank" rel="noopener">
                                                View
                                            </a>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-3 text-center text-secondary">No requests found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
