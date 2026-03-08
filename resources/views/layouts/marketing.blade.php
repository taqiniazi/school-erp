<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'School ERP') }} - @yield('title', 'Modern School Management System')</title>
    
    <!-- Fonts -->
    <link href="{{ asset('css/inter.css') }}" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="{{ asset('font-awesome/css/all.min.css') }}" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top {{ request()->routeIs('home') ? '' : 'bg-body shadow-sm' }}">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap me-2"></i>School ERP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.features') ? 'active' : '' }}" href="{{ route('pages.features') }}">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.pricing') ? 'active' : '' }}" href="{{ route('pages.pricing') }}">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.about') ? 'active' : '' }}" href="{{ route('pages.about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.contact') ? 'active' : '' }}" href="{{ route('pages.contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.blog') ? 'active' : '' }}" href="{{ route('pages.blog') }}">Blog</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-custom">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary-custom">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="{{ request()->routeIs('home') ? '' : 'pt-5 mt-5' }}">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="footer-title">School ERP</h4>
                    <p class="mb-4">A comprehensive solution for educational institutions to manage their day-to-day operations efficiently and effectively.</p>
                    <div>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <a href="{{ route('home') }}" class="footer-link">Home</a>
                    <a href="{{ route('pages.features') }}" class="footer-link">Features</a>
                    <a href="{{ route('pages.pricing') }}" class="footer-link">Pricing</a>
                    <a href="{{ route('pages.about') }}" class="footer-link">About Us</a>
                    <a href="{{ route('pages.contact') }}" class="footer-link">Contact</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-3">Modules</h5>
                    <a href="#" class="footer-link">Student Info</a>
                    <a href="#" class="footer-link">Fee Collection</a>
                    <a href="#" class="footer-link">Attendance</a>
                    <a href="#" class="footer-link">Examinations</a>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">Contact Us</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Tech Park, Innovation Street</p>
                    <p><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope me-2"></i> support@schoolerp.com</p>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4 text-center text-muted small">
                <p>&copy; {{ date('Y') }} School ERP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow-sm');
                document.querySelector('.navbar').style.padding = '0.5rem 0';
            } else {
                if (!document.querySelector('.navbar').classList.contains('bg-body')) {
                    document.querySelector('.navbar').classList.remove('shadow-sm');
                    document.querySelector('.navbar').style.padding = '1rem 0';
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

