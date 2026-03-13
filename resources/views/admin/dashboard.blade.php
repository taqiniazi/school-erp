<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Dashboard Overview</h1>
                <div class="text-muted">Welcome back, here’s what’s happening at your school today</div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('reports.index') }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i> Generate Report
                </a>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#dashboardCustomizeModal">
                    <i class="fas fa-sliders-h me-2"></i> Customize
                </button>
            </div>
        </div>
    </x-slot>

<div class="dashboard container-fluid px-0 py-4">

    <div data-dashboard-grid data-dashboard-key="admin-dashboard">
        <div class="dashboard-widget mb-4" data-widget-key="subscription" data-widget-label="Subscription Status">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-sm btn-light widget-handle" title="Drag">
                    <i class="fas fa-grip-vertical"></i>
                </button>
            </div>
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-lg-8 p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-circle me-3">
                                    <i class="fas fa-crown fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">Current Subscription: {{ $subscription['planName'] }}</h5>
                                    <span class="badge bg-{{ $subscription['status'] === 'active' ? 'success' : 'warning' }} rounded-pill px-3">
                                        {{ ucfirst($subscription['status']) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row g-4 mt-2">
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-semibold text-muted">Students Usage</span>
                                        <span class="small fw-bold">{{ $subscription['studentUsage'] }} / {{ $subscription['studentLimit'] > 0 ? $subscription['studentLimit'] : '∞' }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $subscription['studentLimit'] > 0 ? min(($subscription['studentUsage'] / $subscription['studentLimit']) * 100, 100) : 0 }}%"
                                            aria-valuenow="{{ $subscription['studentUsage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-semibold text-muted">Teachers Usage</span>
                                        <span class="small fw-bold">{{ $subscription['teacherUsage'] }} / {{ $subscription['teacherLimit'] > 0 ? $subscription['teacherLimit'] : '∞' }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{ $subscription['teacherLimit'] > 0 ? min(($subscription['teacherUsage'] / $subscription['teacherLimit']) * 100, 100) : 0 }}%"
                                            aria-valuenow="{{ $subscription['teacherUsage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 bg-light p-4 d-flex flex-column justify-content-center border-start">
                            <div class="mb-3 text-center text-lg-start">
                                <p class="text-muted small mb-1">Plan Expires On</p>
                                <h5 class="fw-bold mb-0">{{ $subscription['expiresAt'] ? \Carbon\Carbon::parse($subscription['expiresAt'])->format('F d, Y') : 'Lifetime Access' }}</h5>
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('billing.choose-plan') }}" class="btn btn-outline-primary fw-semibold">
                                    Upgrade Plan <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-widget mb-4" data-widget-key="stats" data-widget-label="Stats">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-sm btn-light widget-handle" title="Drag">
                    <i class="fas fa-grip-vertical"></i>
                </button>
            </div>
            <div class="row g-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card h-100 border-0 shadow-sm text-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-wrapper bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success">+12%</span>
                            </div>
                            <div class="stats-value text-dark">{{ number_format($totalStudents) }}</div>
                            <div class="stats-label">Total Students</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card h-100 border-0 shadow-sm text-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-wrapper bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success">+5%</span>
                            </div>
                            <div class="stats-value text-dark">{{ number_format($totalTeachers) }}</div>
                            <div class="stats-label">Total Teachers</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card h-100 border-0 shadow-sm text-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-wrapper bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <span class="badge bg-warning bg-opacity-10 text-warning">+2%</span>
                            </div>
                            <div class="stats-value text-dark">{{ number_format($totalParents ?? 0) }}</div>
                            <div class="stats-label">Total Parents</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card h-100 border-0 shadow-sm text-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-wrapper bg-warning bg-opacity-10 text-warning">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success">+8%</span>
                            </div>
                            <div class="stats-value text-dark">$24k</div>
                            <div class="stats-label">Monthly Revenue</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-widget" data-widget-key="activity" data-widget-label="Activity & Quick Actions">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-sm btn-light widget-handle" title="Drag">
                    <i class="fas fa-grip-vertical"></i>
                </button>
            </div>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-dark">Recent Activity</h6>
                            <a href="#" class="text-primary small fw-semibold text-decoration-none">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-4 py-3 border-light">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark fw-semibold">New Student Admission</h6>
                                                <small class="text-muted">Sarah Connor admitted to Class 10A</small>
                                            </div>
                                        </div>
                                        <small class="text-muted">2 hrs ago</small>
                                    </div>
                                </div>
                                <div class="list-group-item px-4 py-3 border-light">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark fw-semibold">Fee Collection</h6>
                                                <small class="text-muted">$450 collected from John Doe</small>
                                            </div>
                                        </div>
                                        <small class="text-muted">4 hrs ago</small>
                                    </div>
                                </div>
                                <div class="list-group-item px-4 py-3 border-light">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3">
                                                <i class="fas fa-bullhorn"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark fw-semibold">Notice Published</h6>
                                                <small class="text-muted">Annual Sports Day announcement</small>
                                            </div>
                                        </div>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-dark">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-3">
                                <a href="{{ route('students.create') }}" class="btn btn-light text-start p-3 d-flex align-items-center hover-primary">
                                    <i class="fas fa-user-graduate text-primary me-3 fa-lg"></i>
                                    <div>
                                        <div class="fw-bold text-dark">Add Student</div>
                                        <div class="small text-muted">Register a new student</div>
                                    </div>
                                </a>
                                <a href="{{ route('teachers.create') }}" class="btn btn-light text-start p-3 d-flex align-items-center hover-primary">
                                    <i class="fas fa-chalkboard-teacher text-success me-3 fa-lg"></i>
                                    <div>
                                        <div class="fw-bold text-dark">Add Teacher</div>
                                        <div class="small text-muted">Onboard new faculty</div>
                                    </div>
                                </a>
                                <a href="#" class="btn btn-light text-start p-3 d-flex align-items-center hover-primary">
                                    <i class="fas fa-file-invoice text-warning me-3 fa-lg"></i>
                                    <div>
                                        <div class="fw-bold text-dark">Create Invoice</div>
                                        <div class="small text-muted">Generate fee invoice</div>
                                    </div>
                                </a>
                                <a href="#" class="btn btn-light text-start p-3 d-flex align-items-center hover-primary">
                                    <i class="fas fa-calendar-alt text-info me-3 fa-lg"></i>
                                    <div>
                                        <div class="fw-bold text-dark">Add Event</div>
                                        <div class="small text-muted">Schedule school event</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dashboardCustomizeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Customize Dashboard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" data-widget-key="subscription" id="widgetSubscription">
                        <label class="form-check-label" for="widgetSubscription">Subscription Status</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" data-widget-key="stats" id="widgetStats">
                        <label class="form-check-label" for="widgetStats">Stats</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" data-widget-key="activity" id="widgetActivity">
                        <label class="form-check-label" for="widgetActivity">Activity & Quick Actions</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
