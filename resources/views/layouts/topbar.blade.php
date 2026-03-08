<nav class="navbar navbar-expand-lg topbar px-0 px-lg-4">
    <div class="container-fluid">
        <!-- Sidebar Toggle (Mobile) -->
        <button type="button" id="sidebarCollapse" class="btn btn-link d-lg-none rounded-circle me-3">
            <i class="fa fa-bars fa-lg text-muted"></i>
        </button>

        <!-- Search Form -->
        <form class="d-none d-md-flex ms-2">
            <div class="input-group">
                <span class="input-group-text bg-light border-0 ps-3 rounded-start-pill text-muted">
                    <i class="fas fa-search"></i>
                </span>
                <input class="form-control bg-light border-0 rounded-end-pill ps-2" type="search" placeholder="Search..." aria-label="Search" style="min-width: 250px;">
            </div>
        </form>

        <!-- Right Side -->
        <ul class="navbar-nav ms-auto align-items-center">
            
            <!-- Quick Actions -->
            <li class="nav-item dropdown me-3 d-none d-sm-block">
                <a class="nav-link" href="#" id="actionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Quick Actions">
                    <i class="fas fa-plus-circle fa-lg text-primary"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" aria-labelledby="actionsDropdown" style="min-width: 200px;">
                    <li><h6 class="dropdown-header text-uppercase small fw-bold">Create New</h6></li>
                    <li><a class="dropdown-item rounded-2" href="{{ route('students.create') }}"><i class="fas fa-user-graduate me-2 text-info"></i> Student</a></li>
                    <li><a class="dropdown-item rounded-2" href="{{ route('teachers.create') }}"><i class="fas fa-chalkboard-teacher me-2 text-success"></i> Teacher</a></li>
                    <li><a class="dropdown-item rounded-2" href="#"><i class="fas fa-file-invoice-dollar me-2 text-warning"></i> Invoice</a></li>
                </ul>
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white small">
                        3
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0" aria-labelledby="notificationDropdown" style="width: 320px;">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                        <h6 class="mb-0 fw-bold">Notifications</h6>
                        <a href="#" class="text-decoration-none small text-primary">Mark all read</a>
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                        <a href="#" class="list-group-item list-group-item-action border-0 px-3 py-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div>
                                    <p class="mb-1 small text-dark fw-medium">New student registration</p>
                                    <p class="mb-0 small text-muted">John Doe registered for Class 10</p>
                                    <small class="text-muted" style="font-size: 0.75rem;">2 mins ago</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-3 py-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <p class="mb-1 small text-dark fw-medium">Fee Payment Received</p>
                                    <p class="mb-0 small text-muted">Invoice #1234 paid by Sarah</p>
                                    <small class="text-muted" style="font-size: 0.75rem;">1 hour ago</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-3 py-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <p class="mb-1 small text-dark fw-medium">Low Attendance Alert</p>
                                    <p class="mb-0 small text-muted">Class 5B attendance is below 80%</p>
                                    <small class="text-muted" style="font-size: 0.75rem;">3 hours ago</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 text-center border-top bg-light rounded-bottom">
                        <a href="#" class="text-decoration-none small fw-bold text-primary">View All Notifications</a>
                    </div>
                </div>
            </li>

            <div class="vr h-50 my-auto mx-2 d-none d-md-block bg-secondary opacity-25"></div>

            <!-- User Dropdown -->
            <li class="nav-item dropdown ms-2">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-end me-2 d-none d-md-block line-height-sm">
                        <div class="fw-bold small text-dark">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->roles->first()->name ?? 'User' }}</div>
                    </div>
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="navbarDropdown">
                    <li class="px-3 py-2 d-md-none border-bottom">
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="small text-muted">{{ Auth::user()->email }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle me-2 text-muted width-20"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center" href="#">
                            <i class="fas fa-cog me-2 text-muted width-20"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item py-2 text-danger d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt me-2 width-20"></i> Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
