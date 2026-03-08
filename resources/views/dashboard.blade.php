<x-app-layout>
    <x-slot name="header">
        {{ __('Welcome, ') . Auth::user()->name }}
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title h5 mb-4">Quick Navigation</h3>
                    <div class="row g-4">
                        @role('Super Admin|School Admin')
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                <div class="card h-100 border-primary bg-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                                                <i class="fas fa-tachometer-alt fa-lg"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-1 text-dark">Admin Dashboard</h5>
                                            <p class="card-text text-muted small">Manage school operations</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endrole

                        @role('Teacher')
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('teacher.dashboard') }}" class="text-decoration-none">
                                <div class="card h-100 border-success bg-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                                                <i class="fas fa-chalkboard-teacher fa-lg"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-1 text-dark">Teacher Dashboard</h5>
                                            <p class="card-text text-muted small">View classes and students</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endrole

                        @role('Student')
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('student.dashboard') }}" class="text-decoration-none">
                                <div class="card h-100 border-primary bg-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                                                <i class="fas fa-user-graduate fa-lg"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-1 text-dark">Student Portal</h5>
                                            <p class="card-text text-muted small">Check grades and attendance</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endrole

                        @role('Parent')
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('parent.dashboard') }}" class="text-decoration-none">
                                <div class="card h-100 border-info bg-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                                                <i class="fas fa-user-friends fa-lg"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-1 text-dark">Parent Portal</h5>
                                            <p class="card-text text-muted small">Monitor children's progress</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endrole
                        
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                                <div class="card h-100 border-secondary bg-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-circle">
                                                <i class="fas fa-user-cog fa-lg"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-1 text-dark">Profile Settings</h5>
                                            <p class="card-text text-muted small">Update account details</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
