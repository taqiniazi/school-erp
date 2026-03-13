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

            <li class="nav-item me-2">
                <button type="button" class="nav-link btn btn-link p-0" id="themeToggle" aria-label="Toggle theme">
                    <i class="fas fa-moon fa-lg"></i>
                </button>
            </li>

            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" id="localeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="localeDropdown" style="min-width: 140px;">
                    <li>
                        <form method="POST" action="{{ route('ui.locale') }}">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <button type="submit" class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('ui.locale') }}">
                            @csrf
                            <input type="hidden" name="locale" value="es">
                            <button type="submit" class="dropdown-item {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</button>
                        </form>
                    </li>
                </ul>
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                   data-notifications-endpoint="{{ route('ui.notifications') }}"
                   data-notifications-mark-all-read="{{ route('ui.notifications.mark-all-read') }}"
                   data-notifications-index-url="{{ route('communication.notifications.index') }}">
                    <i class="far fa-bell fa-lg"></i>
                    <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white small d-none">
                        0
                        <span class="visually-hidden">{{ __('unread notifications') }}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0" aria-labelledby="notificationDropdown" style="width: 320px;">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                        <h6 class="mb-0 fw-bold">{{ __('Notifications') }}</h6>
                        <button type="button" class="btn btn-link p-0 text-decoration-none small text-primary" id="markAllReadBtn">{{ __('Mark all read') }}</button>
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;" id="notificationList"></div>
                    <div class="p-2 text-center border-top bg-light rounded-bottom">
                        <a href="{{ route('communication.notifications.index') }}" class="text-decoration-none small fw-bold text-primary" id="viewAllNotificationsLink">
                            {{ __('View All Notifications') }}
                        </a>
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
