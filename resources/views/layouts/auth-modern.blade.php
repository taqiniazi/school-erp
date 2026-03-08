<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'School ERP') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/inter.css') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- FontAwesome -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="auth-page">

    <div class="auth-container">
        <div class="row g-0">
            <!-- Left Side: Branding/Image -->
            <div class="col-md-6 auth-image-side position-relative overflow-hidden d-none d-md-flex">
                <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle blur-3xl" style="width: 300px; height: 300px; transform: translate(30%, -30%);"></div>
                <div class="position-absolute bottom-0 start-0 bg-secondary opacity-10 rounded-circle blur-3xl" style="width: 200px; height: 200px; transform: translate(-30%, 30%);"></div>
                
                <div class="position-relative z-1 text-white">
                    <h2 class="display-5 fw-bold mb-4">Welcome to School ERP</h2>
                    <p class="lead mb-4 opacity-90">Manage your educational institution with ease. Streamlined administration, enhanced learning.</p>
                    <ul class="list-unstyled fs-5">
                        <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 opacity-75"></i> Comprehensive Student Management</li>
                        <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 opacity-75"></i> Automated Fee Collection</li>
                        <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-3 opacity-75"></i> Real-time Attendance Tracking</li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="col-md-6 auth-form-side">
                <a href="/" class="brand-logo-auth mb-4">
                    <i class="fas fa-graduation-cap me-2"></i>School ERP
                </a>
                
                @yield('content')
                
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>