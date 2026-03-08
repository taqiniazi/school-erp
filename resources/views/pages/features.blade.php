@extends('layouts.marketing')

@section('title', 'Features - School ERP')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center position-relative overflow-hidden">
    <!-- Background Abstract Shapes -->
    <div class="hero-shape-1"></div>
    <div class="hero-shape-2"></div>
    
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <span class="badge bg-primary-custom bg-opacity-10 text-primary-custom px-3 py-2 rounded-pill mb-4 fw-bold">
                    <i class="fas fa-star me-2"></i> All-in-One Solution
                </span>
                <h1 class="hero-title mb-4">
                    Powerful Features for <br>
                    <span class="text-gradient">Modern Schools</span>
                </h1>
                <p class="hero-subtitle mx-auto mb-5">
                    Discover the comprehensive suite of tools designed to streamline administration, enhance learning, and foster better communication.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#core-modules" class="btn btn-primary-custom btn-lg shadow-lg">Explore Modules</a>
                    <a href="{{ route('pages.contact') }}" class="btn btn-outline-custom btn-lg">Request Demo</a>
                </div>
            </div>
        </div>
        
        <!-- Hero Dashboard Image -->
        <div class="mt-5 position-relative" data-aos="fade-up" data-aos-delay="200">
            <div class="browser-window mx-auto" style="max-width: 1000px;">
                <div class="browser-header">
                    <div class="browser-dots">
                        <div class="browser-dot dot-red"></div>
                        <div class="browser-dot dot-yellow"></div>
                        <div class="browser-dot dot-green"></div>
                    </div>
                    <div class="browser-address-bar"></div>
                </div>
                <!-- Fallback if image missing -->
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                    <div class="text-center text-muted opacity-50">
                        <i class="fas fa-columns fa-4x mb-3"></i>
                        <p class="h4">Feature Overview Dashboard</p>
                    </div>
                </div>
                <!-- <img src="{{ asset('images/marketing/dashboard-preview.png') }}" alt="Dashboard Preview" class="hero-image"> -->
            </div>
            
            <!-- Floating Elements -->
            <div class="floating-card floating-card-1 d-none d-lg-flex">
                <div class="stats-icon bg-success">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark">Attendance</div>
                    <div class="small text-muted">Marked Successfully</div>
                </div>
            </div>
            
            <div class="floating-card floating-card-2 d-none d-lg-flex">
                <div class="stats-icon bg-warning text-white">
                    <i class="fas fa-bell"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark">New Notice</div>
                    <div class="small text-muted">Exam Schedule Released</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Modules -->
<section id="core-modules" class="section-padding bg-light position-relative">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Everything You Need</h2>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">A complete ecosystem to manage every aspect of your educational institution.</p>
        </div>

        <div class="row g-4">
            <!-- Student Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Student Information</h4>
                    <p class="text-muted mb-0">Complete student profiles, admission management, document storage, and promotion history tracking.</p>
                </div>
            </div>

            <!-- Academic Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Academic Management</h4>
                    <p class="text-muted mb-0">Manage classes, sections, subjects, timetables, and teacher allocations effortlessly.</p>
                </div>
            </div>

            <!-- Fee Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Fee & Finance</h4>
                    <p class="text-muted mb-0">Automated fee generation, online payments, receipt printing, and comprehensive financial reporting.</p>
                </div>
            </div>

            <!-- Examination System -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Examination & Grading</h4>
                    <p class="text-muted mb-0">Schedule exams, enter marks, calculate grades automatically, and generate professional report cards.</p>
                </div>
            </div>

            <!-- HR & Payroll -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4 class="fw-bold mb-3">HR & Payroll</h4>
                    <p class="text-muted mb-0">Manage staff profiles, attendance, leaves, and automate payroll processing with payslip generation.</p>
                </div>
            </div>

            <!-- Communication -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Communication</h4>
                    <p class="text-muted mb-0">Integrated SMS and email notifications, notice board, and parent-teacher communication channels.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Features Section -->
<section class="section-padding">
    <div class="container">
        <!-- Feature 1 -->
        <div class="row align-items-center mb-5 pb-5">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary-custom opacity-10 rounded-4 transform-rotate-3"></div>
                    <div class="bg-white p-2 rounded-4 shadow-lg position-relative z-1 border">
                        <!-- Fallback/Placeholder -->
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 350px;">
                            <i class="fas fa-chart-pie fa-5x text-secondary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <span class="text-primary-custom fw-bold text-uppercase small letter-spacing-1">Analytics</span>
                <h2 class="fw-bold mb-4 display-6">Advanced Analytics Dashboard</h2>
                <p class="lead text-muted mb-4">Get real-time insights into your school's performance with our intuitive dashboard.</p>
                
                <div class="d-flex align-items-start mb-4">
                    <div class="icon-square bg-success bg-opacity-10 text-success rounded-3 me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Real-time Data</h5>
                        <p class="text-muted mb-0">Monitor student enrollment, attendance rates, and fee collection in real-time.</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start">
                    <div class="icon-square bg-primary-custom bg-opacity-10 text-primary-custom rounded-3 me-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Custom Reports</h5>
                        <p class="text-muted mb-0">Generate detailed reports for administration, board meetings, and parents.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="row align-items-center mt-5 pt-5">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0" data-aos="fade-left">
                 <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-secondary-color opacity-10 rounded-4 transform-rotate-n3"></div>
                    <div class="bg-white p-2 rounded-4 shadow-lg position-relative z-1 border">
                        <!-- Fallback/Placeholder -->
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 350px;">
                            <i class="fas fa-mobile-screen fa-5x text-secondary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1 pe-lg-5" data-aos="fade-right">
                <span class="text-secondary-color fw-bold text-uppercase small letter-spacing-1">Accessibility</span>
                <h2 class="fw-bold mb-4 display-6">Mobile-Ready Portals</h2>
                <p class="lead text-muted mb-4">Stay connected anywhere, anytime. Our platform is fully responsive and works on all devices.</p>
                
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center p-3 rounded-3 bg-light border border-light hover-shadow transition-all">
                        <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                        <span><strong>Parents:</strong> Check attendance, pay fees, view report cards.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center p-3 rounded-3 bg-light border border-light hover-shadow transition-all">
                        <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                        <span><strong>Students:</strong> Access homework, schedules, exam results.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center p-3 rounded-3 bg-light border border-light hover-shadow transition-all">
                        <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                        <span><strong>Teachers:</strong> Mark attendance, enter marks, manage classes.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section-padding bg-dark text-white position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 opacity-10">
        <i class="fas fa-rocket fa-10x transform-rotate-n12"></i>
    </div>
    <div class="container position-relative z-1 text-center">
        <h2 class="display-5 fw-bold mb-4" data-aos="zoom-in">Ready to Modernize Your School?</h2>
        <p class="lead mb-5 opacity-75 mx-auto" style="max-width: 700px;" data-aos="fade-up" data-aos-delay="100">
            Join hundreds of schools that trust School ERP for their daily operations. Start your journey today.
        </p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg px-5 py-3 me-3 fw-bold shadow-lg">Get Started Now</a>
            <a href="{{ route('pages.contact') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">Contact Sales</a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .transform-rotate-3 { transform: rotate(3deg); }
    .transform-rotate-n3 { transform: rotate(-3deg); }
    .transform-rotate-n12 { transform: rotate(-12deg); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; background: #fff !important; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endpush
