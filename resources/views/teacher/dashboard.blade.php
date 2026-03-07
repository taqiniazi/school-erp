<x-app-layout>
    <x-slot name="header">
        {{ __('Teacher Dashboard') }}
    </x-slot>

    <!-- KPIs -->
    <div class="row g-4 mb-4">
        <!-- My Classes -->
        <div class="col-md-4">
            <div class="card border-start border-4 border-primary h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">My Classes</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalClasses ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- My Students -->
        <div class="col-md-4">
            <div class="card border-start border-4 border-success h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Total Students</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalStudents ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Present Today -->
        <div class="col-md-4">
            <div class="card border-start border-4 border-warning h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Present Today</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $presentToday ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Upcoming Events & Notices -->
        <div class="col-lg-8">
            <!-- Upcoming Events -->
            <div class="card mb-4">
                <div class="card-header bg-white border-bottom">
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

            <!-- Recent Notices -->
            <div class="card">
                <div class="card-header bg-white border-bottom">
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

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('attendance.create') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-calendar-check me-2"></i> Take Attendance
                        </a>
                        <a href="{{ route('marks.create') }}" class="btn btn-outline-success text-start">
                            <i class="fas fa-marker me-2"></i> Enter Marks
                        </a>
                        <a href="{{ route('communication.messages.create') }}" class="btn btn-outline-info text-start">
                            <i class="fas fa-envelope me-2"></i> Send Message
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
