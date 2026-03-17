﻿<x-app-layout>
    <x-slot name="header">
        {{ __('Student Dashboard') }}
    </x-slot>

    <div class="dashboard container-fluid px-4 py-4">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card kpi-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="kpi-label">Attendance</div>
                                <div class="kpi-value">{{ $attendancePercentage }}%</div>
                                <div class="kpi-meta">This term attendance rate</div>
                            </div>
                            <div class="kpi-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-user-check"></i>
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
                                <div class="kpi-label">Unpaid Invoices</div>
                                <div class="kpi-value">{{ $unpaidInvoices }}</div>
                                <div class="kpi-meta">Pending fee payments</div>
                            </div>
                            <div class="kpi-icon bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-file-invoice-dollar"></i>
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
                                <div class="kpi-label">Average Marks</div>
                                <div class="kpi-value">{{ $averageMarks }}</div>
                                <div class="kpi-meta">Overall performance score</div>
                            </div>
                            <div class="kpi-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-chart-line"></i>
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
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('student.my-attendance') }}" class="quick-action-tile">
                            <div class="qa-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <div class="qa-title">My Attendance</div>
                                <div class="qa-subtitle">View daily attendance</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('student.report_card') }}" class="quick-action-tile">
                            <div class="qa-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <div class="qa-title">Report Card</div>
                                <div class="qa-subtitle">Check grades and remarks</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('student.invoices') }}" class="quick-action-tile">
                            <div class="qa-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <div class="qa-title">Invoices</div>
                                <div class="qa-subtitle">View and pay fees</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('library.my') }}" class="quick-action-tile">
                            <div class="qa-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <div class="qa-title">My Library</div>
                                <div class="qa-subtitle">Borrowed books and due dates</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('communication.messages.create') }}" class="quick-action-tile">
                            <div class="qa-icon bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="qa-title">Message Teacher</div>
                                <div class="qa-subtitle">Send a quick message</div>
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

            <div class="col-lg-6">
                <div class="card kpi-card h-100">
                    <div class="card-header">
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
    </div>
</x-app-layout>


