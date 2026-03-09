<x-app-layout>
    <div class="container-fluid px-0">
        <!-- Welcome Section -->
        <div class="bg-primary bg-opacity-10 rounded-3 p-4 mb-5 position-relative overflow-hidden">
            <div class="row align-items-center position-relative z-1">
                <div class="col-md-8">
                    <h1 class="display-6 fw-bold text-primary mb-2">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="lead mb-0 text-muted">Select your portal to get started with your school management tasks.</p>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                    <i class="fas fa-school fa-4x text-primary opacity-50"></i>
                </div>
            </div>
            <!-- Decorative Circle -->
            <div class="position-absolute top-0 end-0 bg-white opacity-50 rounded-circle" style="width: 200px; height: 200px; margin-right: -50px; margin-top: -50px;"></div>
        </div>

        <h4 class="fw-bold mb-4 text-dark">Available Portals</h4>

        <div class="row g-4">
            @if(auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'School Admin']))
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 transition-all">
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
                <a href="{{ route('teacher.dashboard') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 transition-all">
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
                <a href="{{ route('student.dashboard') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 transition-all">
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
                <a href="{{ route('parent.dashboard') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 transition-all">
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
                <a href="{{ route('profile.edit') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 transition-all">
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
    
    <style>
        .card-hover-effect .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover-effect:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
</x-app-layout>
