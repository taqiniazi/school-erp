<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'School ERP') }} - Modern School Management System</title>
    
    <!-- Fonts -->
    <link href="{{ asset('css/inter.css') }}" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>School ERP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modules">Modules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#screenshots">Screenshots</a>
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

    <!-- Hero Section -->
    <section id="home" class="hero-section d-flex align-items-center">
        <div class="hero-bg-pattern"></div>
        <div class="hero-shape-1"></div>
        <div class="hero-shape-2"></div>
        
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="d-inline-block px-3 py-1 mb-3 text-sm font-semibold text-primary bg-light rounded-pill border border-primary-subtle">
                        <i class="fas fa-star me-1 text-warning"></i> #1 School Management System
                    </div>
                    <h1 class="hero-title">Manage Your School <br>With <span class="text-primary" style="background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Confidence</span></h1>
                    <p class="hero-subtitle">The most comprehensive ERP solution for modern educational institutions. Streamline administration, enhance learning, and simplify communication.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg shadow-lg">
                            <i class="fas fa-rocket me-2"></i> Start Free Trial
                        </a>
                        <a href="#features" class="btn btn-outline-custom btn-lg">
                            <i class="fas fa-play-circle me-2"></i> Watch Demo
                        </a>
                    </div>
                    <div class="mt-4 pt-2 d-flex align-items-center gap-4 text-muted small">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i> No credit card required
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i> 14-day free trial
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 position-relative" data-aos="fade-left">
                    <!-- Floating Stats Cards -->
                    <div class="floating-card floating-card-1">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">5,000+</div>
                            <div class="small text-muted">Active Students</div>
                        </div>
                    </div>
                    
                    <div class="floating-card floating-card-2">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">99.9%</div>
                            <div class="small text-muted">Uptime Guarantee</div>
                        </div>
                    </div>

                    <!-- Browser Window -->
                    <div class="browser-window">
                        <div class="browser-header">
                            <div class="browser-dots">
                                <div class="browser-dot dot-red"></div>
                                <div class="browser-dot dot-yellow"></div>
                                <div class="browser-dot dot-green"></div>
                            </div>
                            <div class="browser-address-bar"></div>
                        </div>
                        <img src="{{ asset('images/hero-dashboard.jpg') }}" alt="School ERP Dashboard" class="hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Comprehensive Features</h2>
                <p class="text-muted mt-3">Everything you need to manage your educational institution efficiently.</p>
            </div>
            
            <div class="row g-4">
                <!-- Student Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Student Management</h5>
                        <p class="text-muted small">Complete lifecycle management from admission to alumni. Track academic progress and personal details.</p>
                    </div>
                </div>

                <!-- Attendance Tracking -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Attendance Tracking</h5>
                        <p class="text-muted small">Real-time attendance for students and staff. Biometric integration and automated reports.</p>
                    </div>
                </div>

                <!-- Exam Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Exam Management</h5>
                        <p class="text-muted small">Schedule exams, manage grading systems, and generate automated report cards and result analysis.</p>
                    </div>
                </div>

                <!-- Fee Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Fee Management</h5>
                        <p class="text-muted small">Automated fee generation, online payments, receipt printing, and dues tracking.</p>
                    </div>
                </div>

                <!-- Payroll System -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Payroll System</h5>
                        <p class="text-muted small">Manage staff salaries, deductions, bonuses, and generate payslips automatically.</p>
                    </div>
                </div>

                <!-- Library Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="350">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-book"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Library Management</h5>
                        <p class="text-muted small">Catalog books, manage issues/returns, track inventory, and calculate fines.</p>
                    </div>
                </div>

                <!-- Transport Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-bus"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Transport Management</h5>
                        <p class="text-muted small">Manage routes, vehicles, drivers, and track student transport details.</p>
                    </div>
                </div>

                <!-- Communication System -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="450">
                    <div class="feature-card h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Communication System</h5>
                        <p class="text-muted small">SMS and Email alerts for parents, students, and staff. Notice board and event management.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules Overview -->
    <section id="modules" class="section-padding modules-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <img src="{{ asset('images/modules-overview.jpg') }}" alt="Modules Overview" class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <h2 class="section-title mb-4">All-in-One School Management</h2>
                    <p class="text-muted mb-4">Our ERP covers every aspect of school administration, ensuring smooth operations across all departments.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="module-item">
                                <i class="fas fa-user-graduate"></i>
                                <span>Student Management</span>
                            </div>
                            <div class="module-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Teacher & Staff HR</span>
                            </div>
                            <div class="module-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Fee & Finance</span>
                            </div>
                            <div class="module-item">
                                <i class="fas fa-book"></i>
                                <span>Library Management</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="module-item">
                                <i class="fas fa-clipboard-check"></i>
                                <span>Attendance Tracking</span>
                            </div>
                            <div class="module-item">
                                <i class="fas fa-file-alt"></i>
                                <span>Exam & Grading</span>
                            </div>
                            <div class="module-item">
                                <i class="fas fa-bus"></i>
                                <span>Transport System</span>
                            </div>
                            <div class="module-item">
                                <i class="fas fa-boxes"></i>
                                <span>Inventory Control</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#" class="btn btn-primary-custom mt-4">Explore All Modules</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section-padding">
        <div class="container">
            <div class="text-center mb-4" data-aos="fade-up">
                <h2 class="section-title">Simple, Transparent Pricing</h2>
                <p class="text-muted mt-3">Choose the plan that fits your school's size and needs.</p>
            </div>

            <!-- Monthly/Yearly Toggle -->
            <div class="pricing-toggle" data-aos="fade-up" data-aos-delay="50">
                <span class="fw-semibold text-muted">Monthly</span>
                <div class="form-check form-switch p-0 m-0">
                    <input class="form-check-input m-0 shadow-none" type="checkbox" id="pricingToggle">
                </div>
                <span class="fw-bold">Yearly <span class="save-badge">Save 20%</span></span>
            </div>
            
            <div class="row g-4 justify-content-center">
                <!-- Standard Plan -->
                <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-card h-100 p-4">
                        <h4 class="fw-bold mb-3">Standard</h4>
                        <div class="mb-3">
                            <span class="price-tag monthly-price">Rs. 5k</span>
                            <span class="price-tag yearly-price d-none">Rs. 48k</span>
                            <span class="price-period text-muted">/<span class="billing-period">month</span></span>
                        </div>
                        <p class="text-muted small mb-4">Perfect for small schools just starting out.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 500 Students</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 50 Teachers</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 1 Campus</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Core Modules</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Basic Support</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-outline-custom w-100">Get Started</a>
                    </div>
                </div>
                
                <!-- Premium Plan -->
                <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="pricing-card popular h-100 p-4">
                        <div class="popular-badge">Recommended</div>
                        <h4 class="fw-bold mb-3">Premium</h4>
                        <div class="mb-3">
                            <span class="price-tag monthly-price">Rs. 15k</span>
                            <span class="price-tag yearly-price d-none">Rs. 144k</span>
                            <span class="price-period text-muted">/<span class="billing-period">month</span></span>
                        </div>
                        <p class="text-muted small mb-4">Ideal for growing institutions.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 2,000 Students</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 200 Teachers</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 3 Campuses</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> All Modules</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Priority Support</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom w-100 shadow">Get Started</a>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="pricing-card h-100 p-4">
                        <h4 class="fw-bold mb-3">Enterprise</h4>
                        <div class="mb-3">
                            <span class="price-tag">Contact</span>
                        </div>
                        <p class="text-muted small mb-4">For large organizations and universities.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Unlimited Students</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Unlimited Teachers</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Unlimited Campuses</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Custom Features</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Dedicated Manager</li>
                        </ul>
                        <a href="#" class="btn btn-outline-custom w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Trusted by Educators</h2>
                <p class="text-muted mt-3">Hear from the principals and administrators who rely on us.</p>
            </div>
            
            @php
            $testimonials = [
                [
                    'quote' => "This ERP has completely transformed how we manage our school. The automated reports save us hours every week and parents love the transparency.",
                    'name' => "Mr. Ahmed Khan",
                    'role' => "Principal, City High School",
                    'image' => asset('images/testimonial-1.jpg'),
                    'rating' => 5
                ],
                [
                    'quote' => "The fee management system is a lifesaver. We've seen a 40% reduction in late payments since switching to this platform. Highly recommended!",
                    'name' => "Sarah Jenkins",
                    'role' => "Admin Officer, St. Mary's",
                    'image' => asset('images/testimonial-2.jpg'),
                    'rating' => 4.5
                ],
                [
                    'quote' => "Entering marks and attendance is so easy now. I can focus more on teaching and less on paperwork. The mobile interface is fantastic.",
                    'name' => "Michael Chen",
                    'role' => "Senior Coordinator, Greenfield Academy",
                    'image' => asset('images/testimonial-3.jpg'),
                    'rating' => 5
                ]
            ];
            @endphp

            <div class="testimonial-carousel" data-aos="zoom-in">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($testimonials as $index => $t)
                            <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner pb-5">
                        @foreach($testimonials as $index => $testimonial)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row">
                                @for($i = 0; $i < 3; $i++)
                                    @php 
                                        $currentIndex = ($index + $i) % count($testimonials);
                                        $item = $testimonials[$currentIndex];
                                    @endphp
                                    <div class="col-lg-4 {{ $i > 0 ? 'd-none d-lg-block' : '' }}">
                                        <div class="testimonial-card mx-auto">
                                            <i class="fas fa-quote-left quote-icon"></i>
                                            <div class="rating">
                                                @for($j = 1; $j <= 5; $j++)
                                                    @if($j <= $item['rating'])
                                                        <i class="fas fa-star"></i>
                                                    @elseif($j - 0.5 == $item['rating'])
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <!-- <i class="far fa-star"></i> -->
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="lead text-muted fst-italic mb-4">"{{ $item['quote'] }}"</p>
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="testimonial-img mb-3">
                                            <h5 class="fw-bold mb-1">{{ $item['name'] }}</h5>
                                            <small class="text-primary fw-semibold">{{ $item['role'] }}</small>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Product Showcase / Screenshots -->
    <section id="screenshots" class="section-padding">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">See It in Action</h2>
                <p class="text-muted mt-3">Explore our intuitive and powerful dashboard interfaces.</p>
            </div>
            
            @php
            $screenshots = [
                [
                    'title' => 'Admin Dashboard',
                    'desc' => 'Complete overview of school performance, stats, and quick actions.',
                    'img' => asset('images/screenshot-admin.jpg')
                ],
                [
                    'title' => 'Student Management',
                    'desc' => 'Detailed student profiles, academic history, and personal info.',
                    'img' => asset('images/screenshot-student.jpg')
                ],
                [
                    'title' => 'Finance & Fees',
                    'desc' => 'Track payments, generate invoices, and manage expenses effortlessly.',
                    'img' => asset('images/screenshot-finance.jpg')
                ],
                [
                    'title' => 'Attendance Tracking',
                    'desc' => 'Monitor daily attendance for students and staff with detailed reports.',
                    'img' => asset('images/screenshot-attendance.jpg')
                ]
            ];
            @endphp

            <div class="position-relative px-5" data-aos="fade-up" data-aos-delay="100">
                <div id="screenshotCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($screenshots as $index => $s)
                            <button type="button" data-bs-target="#screenshotCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                    
                    <div class="carousel-inner">
                        @foreach($screenshots as $index => $screenshot)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row">
                                @for($i = 0; $i < 3; $i++)
                                    @php 
                                        $currentIndex = ($index + $i) % count($screenshots);
                                        $item = $screenshots[$currentIndex];
                                    @endphp
                                    <div class="col-lg-4 {{ $i > 0 ? 'd-none d-lg-block' : '' }}">
                                        <div class="screenshot-item">
                                            <img src="{{ $item['img'] }}" class="d-block w-100 rounded-4" alt="{{ $item['title'] }}">
                                            <div class="screenshot-overlay rounded-bottom-4">
                                                <h5 class="fw-bold">{{ $item['title'] }}</h5>
                                                <p class="small mb-0">{{ $item['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#screenshotCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#screenshotCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section text-center">
        <div class="container" data-aos="zoom-in">
            <h2 class="fw-bold display-5 mb-4">Start Managing Your School Digitally Today</h2>
            <p class="lead mb-5 opacity-75">Join over 500+ schools that have already modernized their administration.</p>
            
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4">
                    <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-light border-opacity-25 h-100">
                        <i class="fas fa-rocket fa-3x mb-3 opacity-75"></i>
                        <h4 class="fw-bold">Ready to Launch?</h4>
                        <p class="opacity-75 mb-4">Get full access to all features for 14 days. No credit card required.</p>
                        <a href="{{ route('register') }}" class="btn btn-light text-primary fw-bold w-100 py-3">Start Free Trial</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-light border-opacity-25 h-100">
                        <i class="fas fa-laptop-code fa-3x mb-3 opacity-75"></i>
                        <h4 class="fw-bold">Need a Tour?</h4>
                        <p class="opacity-75 mb-4">Schedule a personalized demo with our product experts.</p>
                        <a href="#" class="btn btn-outline-light fw-bold w-100 py-3">Book Demo</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-light border-opacity-25 h-100">
                        <i class="fas fa-headset fa-3x mb-3 opacity-75"></i>
                        <h4 class="fw-bold">Have Questions?</h4>
                        <p class="opacity-75 mb-4">Chat with our sales team to get a custom quote for your school.</p>
                        <a href="#" class="btn btn-outline-light fw-bold w-100 py-3">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <a href="#home" class="footer-link">Home</a>
                    <a href="#features" class="footer-link">Features</a>
                    <a href="#pricing" class="footer-link">Pricing</a>
                    <a href="#screenshots" class="footer-link">Screenshots</a>
                    <a href="#" class="footer-link">Contact</a>
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

        // Pricing Toggle Script
        document.addEventListener('DOMContentLoaded', function() {
            const pricingToggle = document.getElementById('pricingToggle');
            const monthlyPrices = document.querySelectorAll('.monthly-price');
            const yearlyPrices = document.querySelectorAll('.yearly-price');
            const billingPeriods = document.querySelectorAll('.billing-period');

            if(pricingToggle) {
                pricingToggle.addEventListener('change', function() {
                    const isYearly = this.checked;
                    
                    monthlyPrices.forEach(price => {
                        price.classList.toggle('d-none', isYearly);
                    });
                    
                    yearlyPrices.forEach(price => {
                        price.classList.toggle('d-none', !isYearly);
                    });
                    
                    billingPeriods.forEach(period => {
                        period.textContent = isYearly ? 'year' : 'month';
                    });
                });
            }
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow-sm');
                document.querySelector('.navbar').style.padding = '0.5rem 0';
            } else {
                document.querySelector('.navbar').classList.remove('shadow-sm');
                document.querySelector('.navbar').style.padding = '1rem 0';
            }
        });
    </script>
</body>
</html>
