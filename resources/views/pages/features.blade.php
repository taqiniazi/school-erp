@extends('layouts.marketing')

@section('title', 'Features - School ERP')

@section('content')
<style>
    .hero-section {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
    }
</style>
<section class="hero-section d-flex align-items-center bg-primary-custom text-white position-relative overflow-hidden" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Powerful Features for Modern Schools</h1>
                <p class="lead mb-4 opacity-90">Discover the comprehensive suite of tools designed to streamline administration, enhance learning, and foster better communication.</p>
            </div>
        </div>
    </div>
    <!-- Background Abstract Shapes -->
    <div class="position-absolute top-0 end-0 p-5 opacity-10">
        <i class="fas fa-shapes fa-10x"></i>
    </div>
    <div class="position-absolute bottom-0 start-0 p-5 opacity-10">
        <i class="fas fa-cube fa-8x"></i>
    </div>
</section>

<!-- Core Features Grid -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-primary-subtle text-primary-custom px-3 py-2 rounded-pill mb-3">Core Modules</span>
            <h2 class="fw-bold">Everything You Need in One Place</h2>
            <p class="text-muted">A complete ecosystem to manage every aspect of your educational institution.</p>
        </div>

        <div class="row g-4">
            <!-- Student Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-primary-subtle text-primary-custom rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Student Information</h5>
                        <p class="card-text text-muted">Complete student profiles, admission management, document storage, and promotion history tracking.</p>
                    </div>
                </div>
            </div>

            <!-- Academic Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-success-subtle text-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-book-reader fa-2x"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Academic Management</h5>
                        <p class="card-text text-muted">Manage classes, sections, subjects, timetables, and teacher allocations effortlessly.</p>
                    </div>
                </div>
            </div>

            <!-- Fee Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-warning-subtle text-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-file-invoice-dollar fa-2x"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Fee & Finance</h5>
                        <p class="card-text text-muted">Automated fee generation, online payments, receipt printing, and comprehensive financial reporting.</p>
                    </div>
                </div>
            </div>

            <!-- Examination System -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-danger-subtle text-danger rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Examination & Grading</h5>
                        <p class="card-text text-muted">Schedule exams, enter marks, calculate grades automatically, and generate professional report cards.</p>
                    </div>
                </div>
            </div>

            <!-- HR & Payroll -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-info-subtle text-info rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">HR & Payroll</h5>
                        <p class="card-text text-muted">Manage staff profiles, attendance, leaves, and automate payroll processing with payslip generation.</p>
                    </div>
                </div>
            </div>

            <!-- Communication -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-purple-subtle text-purple rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-comments fa-2x"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Communication</h5>
                        <p class="card-text text-muted">Integrated SMS and email notifications, notice board, and parent-teacher communication channels.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Features Section -->
<section class="py-5">
    <div class="container py-5">
        <!-- Feature 1 -->
        <div class="row align-items-center mb-5 pb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="bg-light rounded-4 shadow-sm text-center" style="min-height: 300px; display: flex; align-items: center; justify-content: center;">
                     <!-- <i class="fas fa-chart-line fa-8x text-primary-custom opacity-50"></i> -->
                      <img src="{{ asset('images/marketing/barchart-kids.png') }}" alt="Analytics Dashboard" class="img-fluid"  style="border-radius: 10px;">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-square bg-primary-custom text-white rounded-3 me-3 p-2">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="fw-bold mb-0">Advanced Analytics Dashboard</h3>
                </div>
                <p class="lead text-muted mb-4">Get real-time insights into your school's performance.</p>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>Monitor student enrollment trends and attendance rates daily.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>Track fee collection progress and identify outstanding payments instantly.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>Analyze teacher workload and class performance metrics.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="row align-items-center mb-5 pb-5 flex-lg-row-reverse">
            <div class="col-lg-6" data-aos="fade-left">
                 <div class="bg-light rounded-4 shadow-sm text-center" style="min-height: 300px; display: flex; align-items: center; justify-content: center;">
                      <img src="{{ asset('images/marketing/mobile_ready_portals.png') }}" alt="Mobile-Ready Portals" class="img-fluid" style="border-radius: 10px;">
                </div>
            </div>
            <div class="col-lg-6 pe-lg-5" data-aos="fade-right">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-square bg-success text-white rounded-3 me-3 p-2">
                        <i class="fas fa-mobile-screen"></i>
                    </div>
                    <h3 class="fw-bold mb-0">Mobile-Ready Portals</h3>
                </div>
                <p class="lead text-muted mb-4">Dedicated portals for everyone in the ecosystem.</p>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span><strong>Parents:</strong> Check attendance, pay fees, view report cards, and communicate with teachers.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span><strong>Students:</strong> Access homework, class schedules, exam results, and library books.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span><strong>Teachers:</strong> Mark attendance, enter marks, and manage class activities on the go.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-5">
        <h2 class="display-5 fw-bold mb-4" data-aos="zoom-in">Ready to Modernize Your School?</h2>
        <p class="lead mb-5 opacity-75" data-aos="fade-up" data-aos-delay="100">Join hundreds of schools that trust School ERP for their daily operations.</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg px-5 py-3 me-3 fw-bold">Get Started Now</a>
            <a href="{{ route('pages.contact') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">Contact Sales</a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .bg-purple-subtle {
        background-color: rgba(111, 66, 193, 0.1);
    }
    .text-purple {
        color: #6f42c1;
    }
</style>
@endpush
