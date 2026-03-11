<x-app-layout>
    <x-slot name="header">
        {{ __('Teacher Dashboard') }}
    </x-slot>

    <div class="dashboard container-fluid px-4 py-4">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">My Classes</div>
                                <div class="kpi-value">{{ $totalClasses ?? 0 }}</div>
                                <div class="kpi-meta">Assigned classes and sections</div>
                            </div>
                            <div class="kpi-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Total Students</div>
                                <div class="kpi-value">{{ $totalStudents ?? 0 }}</div>
                                <div class="kpi-meta">Across your classes</div>
                            </div>
                            <div class="kpi-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Present Today</div>
                                <div class="kpi-value">{{ $presentToday ?? 0 }}</div>
                                <div class="kpi-meta">Attendance snapshot</div>
                            </div>
                            <div class="kpi-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card kpi-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">Upcoming Events</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($upcomingEvents as $event)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <div class="fw-bold">{{ $event->title }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y h:i A') }}</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">
                                            {{ $event->type ?? 'Event' }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted fst-italic mb-0">No upcoming events.</p>
                        @endif
                    </div>
                </div>

                <div class="card kpi-card">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">Recent Notices</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($recentNotices) && $recentNotices->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recentNotices as $notice)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <div class="fw-bold">{{ $notice->title }}</div>
                                            <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                                        </div>
                                        <a href="{{ route('communication.notices.show', $notice) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted fst-italic mb-0">No new notices.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card kpi-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('attendance.create') }}" class="quick-action-tile">
                                <div class="qa-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <div class="qa-title">Take Attendance</div>
                                    <div class="qa-subtitle">Mark today’s attendance</div>
                                </div>
                            </a>
                            <a href="{{ route('marks.create') }}" class="quick-action-tile">
                                <div class="qa-icon bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-marker"></i>
                                </div>
                                <div>
                                    <div class="qa-title">Enter Marks</div>
                                    <div class="qa-subtitle">Submit exam results</div>
                                </div>
                            </a>
                            <a href="{{ route('communication.messages.create') }}" class="quick-action-tile">
                                <div class="qa-icon bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <div class="qa-title">Send Message</div>
                                    <div class="qa-subtitle">Communicate with parents</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


