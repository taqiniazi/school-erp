<x-app-layout>
    <x-slot name="header">
        {{ __('Parent Dashboard') }}
    </x-slot>

    <!-- KPIs -->
    <div class="row g-4 mb-4">
        <!-- My Children -->
        <div class="col-md-6">
            <div class="card border-start border-4 border-primary h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">My Children</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $childrenCount }}</div>
                </div>
            </div>
        </div>

        <!-- Outstanding Fees -->
        <div class="col-md-6">
            <div class="card border-start border-4 border-danger h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Outstanding Fees</div>
                    <div class="h3 mb-0 fw-bold text-dark">${{ number_format($outstandingFees, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header bg-body border-bottom">
            <h5 class="mb-0 card-title">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap g-2">
                <a href="{{ route('student.invoices') }}" class="btn btn-primary">
                    Pay Fees
                </a>
                <a href="{{ route('communication.messages.create') }}" class="btn btn-secondary">
                    Message Teacher
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- My Children List -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-body border-bottom">
                    <h5 class="mb-0 card-title">My Children</h5>
                </div>
                <div class="card-body">
                    @if($childrenCount > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($children as $child)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $child->first_name }} {{ $child->last_name }}</div>
                                            <small class="text-muted">Class: {{ $child->class->name ?? 'N/A' }} - {{ $child->section->name ?? 'N/A' }}</small>
                                        </div>
                                        <div class="btn-group btn-group-sm">
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

        <!-- Recent Notices -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-body border-bottom">
                    <h5 class="mb-0 card-title">Recent Notices</h5>
                </div>
                <div class="card-body">
                    @if(isset($recentNotices) && $recentNotices->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentNotices as $notice)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div style="max-width: 60%;">
                                            <div class="fw-bold text-truncate">{{ $notice->title }}</div>
                                            <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                                        </div>
                                        <a href="{{ route('communication.notices.show', $notice) }}" class="btn btn-sm btn-outline-primary">View</a>
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
</x-app-layout>



