<x-app-layout>
    <x-slot name="header">
        {{ __('Admin Dashboard') }}
    </x-slot>

    <!-- KPIs -->
    <div class="row g-4 mb-4">
        <!-- Total Students -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-4 border-primary h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Total Students</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalStudents }}</div>
                </div>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-4 border-success h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Total Teachers</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalTeachers }}</div>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-4 border-warning h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Total Classes</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalClasses }}</div>
                </div>
            </div>
        </div>

        <!-- Monthly Fees -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-4 border-info h-100">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Monthly Fees</div>
                    <div class="h3 mb-0 fw-bold text-dark">${{ number_format($monthlyFeeCollection, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Alerts & Notifications -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 card-title">Alerts & Notifications</h5>
                </div>
                <div class="card-body">
                    @if(isset($lowStockItems) && $lowStockItems > 0)
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Low Stock Alert:</strong> {{ $lowStockItems }} items are below reorder level.
                                <a href="{{ route('inventory.alerts.low_stock') }}" class="alert-link">View Details</a>
                            </div>
                        </div>
                    @endif

                    @if(isset($pendingLeaveRequests) && $pendingLeaveRequests > 0)
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="fas fa-clock me-2"></i>
                            <div>
                                <strong>Pending Leave Requests:</strong> {{ $pendingLeaveRequests }} requests need approval.
                                <a href="{{ route('hr.leave.index') }}" class="alert-link">View Requests</a>
                            </div>
                        </div>
                    @endif

                    @if((!isset($lowStockItems) || $lowStockItems == 0) && (!isset($pendingLeaveRequests) || $pendingLeaveRequests == 0))
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <p>No new alerts or notifications.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('students.create') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-user-plus me-2"></i> Add New Student
                        </a>
                        <a href="{{ route('fee-invoices.create') }}" class="btn btn-outline-success text-start">
                            <i class="fas fa-file-invoice-dollar me-2"></i> Create Fee Invoice
                        </a>
                        <a href="{{ route('attendance.create') }}" class="btn btn-outline-info text-start">
                            <i class="fas fa-calendar-check me-2"></i> Take Attendance
                        </a>
                        <a href="{{ route('communication.notices.create') }}" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-bullhorn me-2"></i> Post Notice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
