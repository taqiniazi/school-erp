<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'School ERP') }} - @yield('title', 'Modern School Management System')</title>
    
    <!-- Fonts -->
    <link href="{{ asset('css/inter.css') }}" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- FontAwesome -->
    
    <!-- AOS Animation -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top transition-all" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <span class="icon-square bg-primary-custom text-white rounded-3 me-2" style="width: 2.5rem; height: 2.5rem; font-size: 1.2rem;">
                    <i class="fas fa-graduation-cap"></i>
                </span>
                <span class="fw-bold text-dark">School ERP</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars fa-lg text-dark"></i>
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
                <div class="d-flex gap-3 mt-3 mt-lg-0">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom px-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-dark fw-bold px-0 me-2">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary-custom px-4 shadow-sm">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer pt-5 pb-2 bg-dark text-white position-relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="position-absolute top-0 end-0 opacity-10">
             <i class="fas fa-circle-notch fa-10x fa-spin" style="animation-duration: 20s;"></i>
        </div>
        
        <div class="container position-relative z-1">
            <div class="row g-5 mb-5">
                <div class="col-lg-4">
                    <a href="{{ route('home') }}" class="d-flex align-items-center text-white text-decoration-none mb-4">
                        <span class="icon-square bg-primary-custom text-white rounded-3 me-2">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        <span class="fw-bold fs-3">School ERP</span>
                    </a>
                    <p class="mb-4 text-secondary">A comprehensive solution for educational institutions to manage their day-to-day operations efficiently and effectively.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                        <li><a href="{{ route('pages.features') }}" class="footer-link">Features</a></li>
                        <li><a href="{{ route('pages.pricing') }}" class="footer-link">Pricing</a></li>
                        <li><a href="{{ route('pages.about') }}" class="footer-link">About Us</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white fw-bold mb-4">Modules</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Student Info</a></li>
                        <li><a href="#" class="footer-link">Fee Collection</a></li>
                        <li><a href="#" class="footer-link">Attendance</a></li>
                        <li><a href="#" class="footer-link">Examinations</a></li>
                        <li><a href="#" class="footer-link">HR & Payroll</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt mt-1 me-3 text-primary-custom"></i> 123 Tech Park, Innovation Street, Silicon Valley, CA</li>
                        <li class="mb-3 d-flex"><i class="fas fa-phone mt-1 me-3 text-primary-custom"></i> +1 (555) 123-4567</li>
                        <li class="mb-3 d-flex"><i class="fas fa-envelope mt-1 me-3 text-primary-custom"></i> support@schoolerp.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary border-opacity-25 pt-4 pb-4 text-center text-secondary small">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start mb-3 mb-md-0">
                        <p class="mb-0">&copy; {{ date('Y') }} School ERP. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-secondary text-decoration-none me-3 hover-white">Privacy Policy</a>
                        <a href="#" class="text-secondary text-decoration-none hover-white">Terms of Service</a>
                    </div>
                </div>
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
        const navbar = document.getElementById('mainNav');
        
        function updateNavbar() {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-sm', 'bg-white', 'py-2');
                navbar.classList.remove('py-4');
            } else {
                // If not on home page, keep white bg
                if (!document.querySelector('.hero-section')) {
                     navbar.classList.add('bg-white', 'shadow-sm', 'py-2');
                } else {
                    navbar.classList.remove('shadow-sm', 'bg-white', 'py-2');
                    navbar.classList.add('py-4');
                }
            }
        }

        window.addEventListener('scroll', updateNavbar);
        
        // Initial check
        if (!document.querySelector('.hero-section')) {
             navbar.classList.add('bg-white', 'shadow-sm', 'py-2');
        } else {
             navbar.classList.add('py-4');
             updateNavbar();
        }

        function cleanupOverlays() {
            const hasShownModal = document.querySelector('.modal.show, .modal.showing, .offcanvas.show, .offcanvas.showing');
            if (hasShownModal) return;
            document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach((el) => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        }

        window.addEventListener('pageshow', cleanupOverlays);
        cleanupOverlays();
        window.setTimeout(cleanupOverlays, 50);
        window.setTimeout(cleanupOverlays, 300);
    </script>
    @stack('scripts')
</body>
</html>
