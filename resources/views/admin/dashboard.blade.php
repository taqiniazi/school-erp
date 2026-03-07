@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('reports.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Subscription Status Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-left-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Current Subscription
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $subscription['planName'] }} 
                                <span class="badge bg-{{ $subscription['status'] === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($subscription['status']) }}
                                </span>
                            </div>
                            <div class="mt-2 small text-muted">
                                Expires: {{ $subscription['expiresAt'] ? \Carbon\Carbon::parse($subscription['expiresAt'])->format('M d, Y') : 'Never' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Students</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $subscription['studentUsage'] }} / {{ $subscription['studentLimit'] > 0 ? $subscription['studentLimit'] : '∞' }}
                                    </div>
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                            style="width: {{ $subscription['studentLimit'] > 0 ? min(($subscription['studentUsage'] / $subscription['studentLimit']) * 100, 100) : 0 }}%" 
                                            aria-valuenow="{{ $subscription['studentUsage'] }}" aria-valuemin="0" aria-valuemax="{{ $subscription['studentLimit'] }}"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Teachers</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        {{ $subscription['teacherUsage'] }} / {{ $subscription['teacherLimit'] > 0 ? $subscription['teacherLimit'] : '∞' }}
                                    </div>
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                            style="width: {{ $subscription['teacherLimit'] > 0 ? min(($subscription['teacherUsage'] / $subscription['teacherLimit']) * 100, 100) : 0 }}%" 
                                            aria-valuenow="{{ $subscription['teacherUsage'] }}" aria-valuemin="0" aria-valuemax="{{ $subscription['teacherLimit'] }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('billing.choose-plan') }}" class="btn btn-sm btn-outline-primary">Upgrade Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row">
        <!-- Total Students -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Teachers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTeachers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Classes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClasses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Fees -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Monthly Fees</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rs. {{ number_format($monthlyFeeCollection, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Alerts & Notifications -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alerts & Notifications</h6>
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
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
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
</div>
@endsection
