@extends('layouts.marketing')

@section('title', 'Modern School Management System')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero-section d-flex align-items-center position-relative overflow-hidden">
        <div class="hero-bg-pattern"></div>
        <div class="hero-shape-1"></div>
        <div class="hero-shape-2"></div>
        <div class="hero-shape-3"></div>
        
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <div class="d-inline-flex align-items-center px-3 py-1 mb-4 small fw-bold text-primary bg-white rounded-pill border border-primary-subtle shadow-sm">
                        <span class="badge bg-primary me-2 rounded-pill">New</span>
                        <span>#1 Rated School Management System</span>
                    </div>
                    <h1 class="hero-title display-4 fw-bolder mb-4 text-dark">
                        Manage Your School <br>
                        With <span class="text-gradient">Confidence</span>
                    </h1>
                    <p class="hero-subtitle lead mb-5 text-muted">
                        The most comprehensive ERP solution for modern educational institutions. Streamline administration, enhance learning, and simplify communication with one powerful platform.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg shadow-lg px-5 py-3 rounded-pill">
                            <i class="fas fa-rocket me-2"></i> Start Free Trial
                        </a>
                        <a href="{{ route('pages.features') }}" class="btn btn-outline-custom btn-lg px-5 py-3 rounded-pill">
                            <i class="fas fa-play-circle me-2"></i> Watch Demo
                        </a>
                    </div>
                    <div class="mt-5 pt-3 d-flex align-items-center gap-4 text-muted small border-top border-light-subtle">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2 fa-lg"></i> 
                            <span>No credit card required</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2 fa-lg"></i> 
                            <span>14-day free trial</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2 fa-lg"></i> 
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 position-relative" data-aos="fade-left">
                    <!-- Floating Stats Cards -->
                    <div class="floating-card floating-card-1">
                        <div class="stats-icon bg-success bg-gradient shadow-sm">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark h5 mb-0">5,000+</div>
                            <div class="small text-muted">Active Students</div>
                        </div>
                    </div>
                    
                    <div class="floating-card floating-card-2">
                        <div class="stats-icon bg-primary bg-gradient shadow-sm">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark h5 mb-0">99.9%</div>
                            <div class="small text-muted">Uptime Guarantee</div>
                        </div>
                    </div>

                    <div class="floating-card floating-card-3">
                        <div class="stats-icon bg-warning bg-gradient shadow-sm">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark h5 mb-0">4.9/5</div>
                            <div class="small text-muted">User Rating</div>
                        </div>
                    </div>

                    <!-- Browser Window -->
                    <div class="browser-window shadow-lg border-0">
                        <div class="browser-header">
                            <div class="browser-dots">
                                <div class="browser-dot dot-red"></div>
                                <div class="browser-dot dot-yellow"></div>
                                <div class="browser-dot dot-green"></div>
                            </div>
                            <div class="browser-address-bar shadow-sm"></div>
                        </div>
                        <div class="position-relative">
                             <img src="{{ asset('images/hero-dashboard.jpg') }}" alt="School ERP Dashboard" class="hero-image" style="min-height: 400px; object-fit: cover; background-color: #f3f4f6;">
                             <!-- Overlay for placeholder if image missing -->
                             <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted" style="z-index: -1;">
                                 <div class="text-center">
                                     <i class="fas fa-chart-line fa-3x mb-3 opacity-50"></i>
                                     <p>Dashboard Preview</p>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By Section -->
    <section class="py-5 bg-light border-bottom position-relative overflow-hidden">
        <div class="container position-relative z-1">
            <div class="text-center mb-5">
                <span class="badge bg-white text-primary border shadow-sm px-3 py-2 rounded-pill mb-3 text-uppercase fw-bold small tracking-wide">Trusted Partners</span>
                <h2 class="h4 fw-bold text-dark mb-0">Trusted by 500+ Educational Institutions</h2>
            </div>
            
            <div class="row justify-content-center align-items-center g-4 g-lg-5">
                <!-- Partner 1 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo p-3 text-center opacity-50 hover-opacity-100 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Global University">
                        <i class="fas fa-university fa-3x text-dark mb-2 d-block"></i>
                        <span class="small fw-bold text-muted d-none d-md-block">Global Univ</span>
                    </div>
                </div>
                
                <!-- Partner 2 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo p-3 text-center opacity-50 hover-opacity-100 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Future Academy">
                        <i class="fas fa-graduation-cap fa-3x text-dark mb-2 d-block"></i>
                        <span class="small fw-bold text-muted d-none d-md-block">Future Acad</span>
                    </div>
                </div>
                
                <!-- Partner 3 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo p-3 text-center opacity-50 hover-opacity-100 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Smart School System">
                        <i class="fas fa-school fa-3x text-dark mb-2 d-block"></i>
                        <span class="small fw-bold text-muted d-none d-md-block">Smart School</span>
                    </div>
                </div>
                
                <!-- Partner 4 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo p-3 text-center opacity-50 hover-opacity-100 transition-all cursor-pointer" data-bs-toggle="tooltip" title="E-Learning Institute">
                        <i class="fas fa-book-reader fa-3x text-dark mb-2 d-block"></i>
                        <span class="small fw-bold text-muted d-none d-md-block">E-Learning</span>
                    </div>
                </div>
                
                <!-- Partner 5 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo p-3 text-center opacity-50 hover-opacity-100 transition-all cursor-pointer" data-bs-toggle="tooltip" title="Teachers Association">
                        <i class="fas fa-chalkboard-teacher fa-3x text-dark mb-2 d-block"></i>
                        <span class="small fw-bold text-muted d-none d-md-block">Teachers Assoc</span>
                    </div>
                </div>
                
                <!-- Partner 6 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="partner-logo p-3 text-center opacity-50 hover-opacity-100 transition-all cursor-pointer" data-bs-toggle="tooltip" title="International Campus">
                        <i class="fas fa-globe-americas fa-3x text-dark mb-2 d-block"></i>
                        <span class="small fw-bold text-muted d-none d-md-block">Intl Campus</span>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .hover-opacity-100:hover {
                opacity: 1 !important;
                transform: translateY(-5px);
            }
            .transition-all {
                transition: all 0.3s ease;
            }
            .partner-logo i {
                transition: color 0.3s ease;
            }
            .partner-logo:hover i {
                color: var(--bs-primary) !important;
            }
        </style>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding bg-light position-relative">
        <div class="container">
            <div class="text-center mb-5 pb-3" data-aos="fade-up">
                <span class="badge bg-primary-subtle text-primary-custom rounded-pill px-3 py-2 mb-3 fw-bold">Why Choose Us</span>
                <h2 class="section-title mb-3">Comprehensive Features</h2>
                <p class="text-muted lead mx-auto" style="max-width: 700px;">Everything you need to manage your educational institution efficiently in one unified platform.</p>
            </div>
            
            <div class="row g-4">
                <!-- Student Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card h-100 text-center">
                        <div class="feature-icon mx-auto shadow-sm">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="fw-bold mb-3 h4">Student Management</h5>
                        <p class="text-muted">Complete lifecycle management from admission to alumni. Track academic progress and personal details effortlessly.</p>
                    </div>
                </div>

                <!-- Attendance Tracking -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                    <div class="feature-card h-100 text-center">
                        <div class="feature-icon mx-auto shadow-sm">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="fw-bold mb-3 h4">Attendance Tracking</h5>
                        <p class="text-muted">Real-time attendance for students and staff. Biometric integration and automated daily reports.</p>
                    </div>
                </div>

                <!-- Exam Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card h-100 text-center">
                        <div class="feature-icon mx-auto shadow-sm">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3 h4">Exam Management</h5>
                        <p class="text-muted">Schedule exams, manage grading systems, and generate automated report cards and result analysis.</p>
                    </div>
                </div>

                <!-- Fee Management -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
                    <div class="feature-card h-100 text-center">
                        <div class="feature-icon mx-auto shadow-sm">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="fw-bold mb-3 h4">Fee Management</h5>
                        <p class="text-muted">Automated fee generation, online payments, receipt printing, and dues tracking with reminders.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5 pt-3">
                <a href="{{ route('pages.features') }}" class="btn btn-outline-custom btn-lg rounded-pill px-4">
                    View All Features <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Modules Overview with Alternating Layout -->
    <section id="modules" class="section-padding bg-white overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5" data-aos="fade-right">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-10 rounded-4 transform-rotate-3" style="transform: rotate(-3deg);"></div>
                        <img src="{{ asset('images/modules-overview.jpg') }}" alt="Modules Overview" class="img-fluid rounded-4 shadow-lg position-relative bg-white">
                         <!-- Fallback if image missing -->
                         <div class="d-none bg-light rounded-4 shadow-lg d-flex align-items-center justify-content-center" style="height: 400px;">
                            <i class="fas fa-layer-group fa-4x text-muted opacity-25"></i>
                         </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 mb-3 fw-bold">Unified Platform</span>
                    <h2 class="section-title mb-4">All-in-One School Management</h2>
                    <p class="text-muted mb-4 lead">Our ERP covers every aspect of school administration, ensuring smooth operations across all departments.</p>
                    
                    <div class="row g-3">
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
                    
                    <a href="{{ route('pages.features') }}" class="btn btn-primary-custom mt-4 btn-lg rounded-pill">
                        Explore All Modules <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section-padding bg-primary-custom text-white position-relative overflow-hidden">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('data:image/svg+xml,...'); opacity: 0.1;"></div>
        <div class="container position-relative z-1">
            <div class="row text-center g-4">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="display-4 fw-bold mb-2">50+</div>
                    <p class="mb-0 opacity-75">Schools</p>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="display-4 fw-bold mb-2">5k+</div>
                    <p class="mb-0 opacity-75">Students</p>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="display-4 fw-bold mb-2">200+</div>
                    <p class="mb-0 opacity-75">Teachers</p>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="display-4 fw-bold mb-2">1M+</div>
                    <p class="mb-0 opacity-75">Records Processed</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding position-relative">
        <div class="container">
            <div class="bg-dark text-white rounded-5 p-5 position-relative overflow-hidden shadow-lg" data-aos="zoom-in">
                <div class="position-absolute top-0 end-0 p-5 opacity-10">
                    <i class="fas fa-rocket fa-10x"></i>
                </div>
                <div class="row align-items-center position-relative z-1">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="fw-bold display-5 mb-3">Ready to Transform Your School?</h2>
                        <p class="lead opacity-75 mb-0">Join hundreds of modern institutions using our ERP to streamline their operations.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-primary shadow">
                            Get Started Now
                        </a>
                        <div class="mt-3 small opacity-75">
                            <i class="fas fa-check-circle me-1"></i> 14-day free trial
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
