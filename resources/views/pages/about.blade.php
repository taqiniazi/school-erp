@extends('layouts.marketing')

@section('title', 'About Us - School ERP')

@section('content')
<style>
    .hero-section {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
    }
</style>
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center bg-primary-custom text-white position-relative overflow-hidden" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Empowering Education Through Technology</h1>
                <p class="lead mb-4 opacity-90">We are on a mission to simplify school management and enhance the learning experience for everyone.</p>
            </div>
        </div>
    </div>
    <!-- Background Abstract Shapes -->
    <div class="position-absolute top-0 end-0 p-5 opacity-10">
        <i class="fas fa-globe-americas fa-10x"></i>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="p-5 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center">
                    <div class="icon-square bg-primary-custom text-white rounded-3 mb-4 p-3 d-inline-block">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Our Mission</h3>
                    <p class="text-muted lead">To provide educational institutions with intuitive, powerful, and affordable software solutions that reduce administrative burden and focus resources on what matters most: student success.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="p-5 bg-light rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center">
                    <div class="icon-square bg-success text-white rounded-3 mb-4 p-3 d-inline-block">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Our Vision</h3>
                    <p class="text-muted lead">A world where every school, regardless of size or location, has access to world-class technology that fosters efficient operations and engaged learning communities.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row align-items-center">
             <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                <div class="position-relative">
                    <div class="bg-primary-custom rounded-4 position-absolute top-0 start-0 w-100 h-100" style="transform: rotate(3deg); opacity: 0.1;"></div>
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Team collaborating" class="img-fluid rounded-4 shadow position-relative z-1">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1 pe-lg-5" data-aos="fade-right">
                <h2 class="fw-bold mb-4">Our Journey</h2>
                <p class="text-muted mb-4">Founded in 2023, School ERP started with a simple idea: school management software shouldn't be complicated or expensive. What began as a small project for a local school has grown into a comprehensive platform trusted by institutions worldwide.</p>
                <p class="text-muted mb-4">We believe in continuous innovation. Our team works closely with educators and administrators to understand their challenges and build features that solve real-world problems.</p>
                
                <div class="row g-4 mt-4">
                    <div class="col-6 col-md-4 text-center">
                        <h3 class="fw-bold text-primary-custom display-6">500+</h3>
                        <p class="text-muted small">Schools Partnered</p>
                    </div>
                    <div class="col-6 col-md-4 text-center">
                        <h3 class="fw-bold text-primary-custom display-6">1M+</h3>
                        <p class="text-muted small">Students Managed</p>
                    </div>
                    <div class="col-6 col-md-4 text-center">
                        <h3 class="fw-bold text-primary-custom display-6">99%</h3>
                        <p class="text-muted small">Customer Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Meet the Team</h2>
            <p class="text-muted">The passionate people behind School ERP.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Member 1 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <img src="{{ asset('images/marketing/alex-morgan.png') }}" alt="Alex Morgan" class="rounded-circle shadow-sm" width="128" height="128">
                        </div>
                        <h5 class="fw-bold mb-1">Alex Morgan</h5>
                        <p class="text-muted small mb-3">CEO & Founder</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-twitter fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Member 2 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <img src="{{ asset('images/marketing/sarah-chen.png') }}" alt="Sarah Chen" class="rounded-circle shadow-sm" width="128" height="128">
                        </div>
                        <h5 class="fw-bold mb-1">Sarah Chen</h5>
                        <p class="text-muted small mb-3">CTO</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-github fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Member 3 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                         <div class="mb-4">
                            <img src="{{ asset('images/marketing/david-kim.png') }}" alt="David Kim" class="rounded-circle shadow-sm" width="128" height="128">
                        </div>
                        <h5 class="fw-bold mb-1">David Kim</h5>
                        <p class="text-muted small mb-3">Head of Product</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-twitter fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Member 4 -->
             <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                         <div class="mb-4">
                            <img src="{{ asset('images/marketing/emily-davis.png') }}" alt="Emily Davis" class="rounded-circle shadow-sm" width="128" height="128">
                        </div>
                        <h5 class="fw-bold mb-1">Emily Davis</h5>
                        <p class="text-muted small mb-3">Customer Success</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fas fa-envelope fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection




