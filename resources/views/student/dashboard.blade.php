<x-app-layout>
    <x-slot name="header">
        {{ __('Student Dashboard') }}
    </x-slot>

    <!-- KPIs -->
    <div class="row g-4 mb-4">
        <!-- Attendance % -->
        <div class="col-md-4">
            <div class="card border-start border-4 border-primary h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Attendance</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $attendancePercentage }}%</div>
                </div>
            </div>
        </div>

        <!-- Unpaid Invoices -->
        <div class="col-md-4">
            <div class="card border-start border-4 border-danger h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Unpaid Invoices</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $unpaidInvoices }}</div>
                </div>
            </div>
        </div>

        <!-- Average Marks -->
        <div class="col-md-4">
            <div class="card border-start border-4 border-warning h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Average Marks</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $averageMarks }}</div>
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
                <a href="{{ route('student.my-attendance') }}" class="btn btn-primary">
                    View My Attendance
                </a>
                <a href="{{ route('student.report_card') }}" class="btn btn-success">
                    View Report Card
                </a>
                <a href="{{ route('student.invoices') }}" class="btn btn-warning text-white">
                    My Invoices
                </a>
                <a href="{{ route('library.my') }}" class="btn btn-info text-white">
                    My Library
                </a>
                <a href="{{ route('communication.messages.create') }}" class="btn btn-secondary">
                    Message Teacher
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Upcoming Exams -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-body border-bottom">
                    <h5 class="mb-0 card-title">Upcoming Exams</h5>
                </div>
                <div class="card-body">
                    @if(isset($upcomingExams) && $upcomingExams->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($upcomingExams as $exam)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $exam->subject->name ?? 'Subject' }}</div>
                                            <small class="text-muted">{{ $exam->exam->name ?? 'Exam' }}</small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted fst-italic mb-0">No upcoming exams.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-body border-bottom">
                    <h5 class="mb-0 card-title">Upcoming Events</h5>
                </div>
                <div class="card-body">
                    @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($upcomingEvents as $event)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fw-bold">{{ $event->title }}</div>
                                        <span class="badge bg-info text-white rounded-pill">
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted fst-italic mb-0">No upcoming events.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



