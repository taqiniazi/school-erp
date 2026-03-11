<x-app-layout>
    <x-slot name="header">
        {{ __('Parent Dashboard') }}
    </x-slot>

    <div class="dashboard container-fluid px-4 py-4">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">My Children</div>
                                <div class="kpi-value">{{ $childrenCount }}</div>
                                <div class="kpi-meta">Linked student profiles</div>
                            </div>
                            <div class="kpi-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Outstanding Fees</div>
                                <div class="kpi-value">${{ number_format($outstandingFees, 2) }}</div>
                                <div class="kpi-meta">Pending invoices</div>
                            </div>
                            <div class="kpi-icon bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card kpi-card mb-4">
            <div class="card-header">
                <h5 class="mb-0 card-title">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('student.invoices') }}" class="quick-action-tile">
                            <div class="qa-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <div class="qa-title">Pay Fees</div>
                                <div class="qa-subtitle">View invoices and pay online</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('communication.messages.create') }}" class="quick-action-tile">
                            <div class="qa-icon bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="qa-title">Message Teacher</div>
                                <div class="qa-subtitle">Send a message quickly</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card kpi-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">My Children</h5>
                    </div>
                    <div class="card-body">
                        @if($childrenCount > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($children as $child)
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">{{ $child->first_name }} {{ $child->last_name }}</div>
                                                <small class="text-muted">Class: {{ $child->class->name ?? 'N/A' }} - {{ $child->section->name ?? 'N/A' }}</small>
                                            </div>
                                            <div class="btn-group btn-group-sm flex-shrink-0">
                                                <a href="{{ route('student.report_card', ['student_id' => $child->id]) }}" class="btn btn-outline-success">Report Card</a>
                                                <a href="{{ route('student.my-attendance', ['student_id' => $child->id]) }}" class="btn btn-outline-primary">Attendance</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted fst-italic mb-0">No children linked.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card kpi-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">Recent Notices</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($recentNotices) && $recentNotices->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recentNotices as $notice)
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <div class="flex-grow-1" style="min-width: 0;">
                                                <div class="fw-bold text-truncate">{{ $notice->title }}</div>
                                                <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>
                                            <a href="{{ route('communication.notices.show', $notice) }}" class="btn btn-sm btn-outline-primary flex-shrink-0">View</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted fst-italic mb-0">No new notices.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


