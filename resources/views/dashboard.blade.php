<x-app-layout>
    <div class="dashboard container-fluid px-0">
        <div class="dashboard-hero mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 position-relative z-1">
                <div>
                    <div class="dashboard-title">Welcome, {{ Auth::user()->name }}!</div>
                    <div class="dashboard-subtitle">Select your portal to get started</div>
                </div>
                <div class="d-none d-md-flex align-items-center gap-3">
                    <i class="fas fa-school fa-3x opacity-75"></i>
                </div>
            </div>
        </div>

        <h4 class="fw-bold mb-4 text-dark">Available Portals</h4>

        <div class="row g-4">
            @if(auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'School Admin']))
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                    <div class="card kpi-card h-100 text-center py-4">
                        <div class="card-body">
                            <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Admin Dashboard</h5>
                            <p class="text-muted small mb-0">Manage school operations, users, and reports</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            @if(auth()->check() && auth()->user()->hasRole('Teacher'))
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('teacher.dashboard') }}" class="text-decoration-none">
                    <div class="card kpi-card h-100 text-center py-4">
                        <div class="card-body">
                            <div class="icon-square bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Teacher Dashboard</h5>
                            <p class="text-muted small mb-0">Manage classes, students, and attendance</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            @if(auth()->check() && auth()->user()->hasRole('Student'))
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('student.dashboard') }}" class="text-decoration-none">
                    <div class="card kpi-card h-100 text-center py-4">
                        <div class="card-body">
                            <div class="icon-square bg-info bg-opacity-10 text-info rounded-circle mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Student Portal</h5>
                            <p class="text-muted small mb-0">View grades, schedule, and attendance</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            @if(auth()->check() && auth()->user()->hasRole('Parent'))
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('parent.dashboard') }}" class="text-decoration-none">
                    <div class="card kpi-card h-100 text-center py-4">
                        <div class="card-body">
                            <div class="icon-square bg-warning bg-opacity-10 text-warning rounded-circle mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Parent Portal</h5>
                            <p class="text-muted small mb-0">Monitor your child's progress</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                    <div class="card kpi-card h-100 text-center py-4">
                        <div class="card-body">
                            <div class="icon-square bg-secondary bg-opacity-10 text-secondary rounded-circle mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Profile Settings</h5>
                            <p class="text-muted small mb-0">Update your account information</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
