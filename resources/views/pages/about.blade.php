@extends('layouts.marketing')

@section('title', 'About Us - School ERP')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center position-relative overflow-hidden">
    <!-- Background Abstract Shapes -->
    <div class="hero-shape-2"></div>
    <div class="hero-shape-3"></div>
    
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <span class="badge bg-secondary bg-opacity-10 text-secondary-color px-3 py-2 rounded-pill mb-4 fw-bold">
                    <i class="fas fa-heart me-2"></i> Our Mission
                </span>
                <h1 class="hero-title mb-4">
                    Empowering Education Through <br>
                    <span class="text-gradient-secondary">Technology</span>
                </h1>
                <p class="hero-subtitle mx-auto mb-5">
                    We are on a mission to simplify school management and enhance the learning experience for everyone.
                </p>
            </div>
        </div>
        
        <div class="row justify-content-center mt-4">
             <div class="col-lg-10" data-aos="fade-up" data-aos-delay="200">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-50 translate-middle-x w-100 h-100 bg-primary-custom opacity-10 rounded-5 transform-rotate-3" style="max-width: 900px;"></div>
                     <!-- Fallback if image missing -->
                     <div class="bg-light rounded-5 shadow-lg mx-auto d-flex align-items-center justify-content-center position-relative z-1" style="height: 400px; max-width: 900px;">
                        <div class="text-center text-muted opacity-50">
                             <i class="fas fa-users fa-5x mb-3"></i>
                             <p class="h4">Team Collaboration</p>
                        </div>
                     </div>
                    <!-- <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Team collaborating" class="img-fluid rounded-5 shadow-lg position-relative z-1 mx-auto d-block" style="max-width: 900px;"> -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row g-5 align-items-stretch">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="feature-card h-100 bg-white border-0 shadow-sm p-5">
                    <div class="icon-square bg-primary-custom text-white rounded-3 mb-4 p-3 d-inline-block shadow-md">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Our Mission</h3>
                    <p class="text-muted lead">To provide educational institutions with intuitive, powerful, and affordable software solutions that reduce administrative burden and focus resources on what matters most: student success.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="feature-card h-100 bg-white border-0 shadow-sm p-5">
                    <div class="icon-square bg-success text-white rounded-3 mb-4 p-3 d-inline-block shadow-md">
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
<section class="section-padding position-relative overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
             <div class="col-lg-6 order-lg-2 mb-5 mb-lg-0" data-aos="fade-left">
                <div class="position-relative ps-lg-5">
                    <div class="position-absolute top-0 end-0 w-75 h-75 bg-warning-color opacity-10 rounded-circle blur-3xl"></div>
                     <div class="bg-light rounded-4 shadow-lg d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center text-muted opacity-50">
                             <i class="fas fa-history fa-5x mb-3"></i>
                             <p class="h4">Our Journey Image</p>
                        </div>
                     </div>
                    <!-- <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Our Story" class="img-fluid rounded-4 shadow-lg position-relative z-1"> -->
                    
                    <!-- Floating Stat -->
                    <div class="floating-card floating-card-3" style="bottom: -20px; right: 20px; top: auto;">
                        <div class="stats-icon bg-primary-custom">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Founded</div>
                            <div class="small text-muted">2023</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1 pe-lg-5" data-aos="fade-right">
                <span class="text-primary-custom fw-bold text-uppercase small letter-spacing-1">History</span>
                <h2 class="fw-bold mb-4 display-6">Our Journey</h2>
                <p class="text-muted mb-4 lead">Founded in 2023, School ERP started with a simple idea: school management software shouldn't be complicated or expensive.</p>
                <p class="text-muted mb-4">What began as a small project for a local school has grown into a comprehensive platform trusted by institutions worldwide. We believe in continuous innovation. Our team works closely with educators and administrators to understand their challenges and build features that solve real-world problems.</p>
                
                <div class="row g-4 mt-4">
                    <div class="col-4 text-center border-end">
                        <h3 class="fw-bold text-primary-custom display-6 mb-0">500+</h3>
                        <p class="text-muted small text-uppercase fw-bold">Schools</p>
                    </div>
                    <div class="col-4 text-center border-end">
                        <h3 class="fw-bold text-secondary-color display-6 mb-0">1M+</h3>
                        <p class="text-muted small text-uppercase fw-bold">Students</p>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="fw-bold text-success display-6 mb-0">99%</h3>
                        <p class="text-muted small text-uppercase fw-bold">Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold display-6">Meet the Team</h2>
            <p class="text-muted">The passionate people behind School ERP.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Member 1 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-4 shadow-sm text-center h-100 overflow-hidden hover-lift transition-all border border-light">
                    <div class="p-4 pb-0">
                         <div class="rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 120px; height: 120px; overflow: hidden;">
                             <img src="{{ asset('images/marketing/alex-morgan.png') }}" alt="Alex Morgan" class="img-fluid" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Alex+Morgan&background=random';">
                         </div>
                    </div>
                    <div class="p-4 pt-2">
                        <h5 class="fw-bold mb-1">Alex Morgan</h5>
                        <p class="text-primary-custom small mb-3 fw-bold text-uppercase">CEO & Founder</p>
                        <p class="text-muted small mb-4">Visionary leader with 15+ years in EdTech.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-twitter fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Member 2 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-4 shadow-sm text-center h-100 overflow-hidden hover-lift transition-all border border-light">
                    <div class="p-4 pb-0">
                         <div class="rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 120px; height: 120px; overflow: hidden;">
                             <img src="{{ asset('images/marketing/sarah-chen.png') }}" alt="Sarah Chen" class="img-fluid" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Sarah+Chen&background=random';">
                         </div>
                    </div>
                    <div class="p-4 pt-2">
                        <h5 class="fw-bold mb-1">Sarah Chen</h5>
                        <p class="text-primary-custom small mb-3 fw-bold text-uppercase">CTO</p>
                        <p class="text-muted small mb-4">Tech wizard ensuring 99.9% uptime.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-github fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Member 3 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-4 shadow-sm text-center h-100 overflow-hidden hover-lift transition-all border border-light">
                    <div class="p-4 pb-0">
                         <div class="rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 120px; height: 120px; overflow: hidden;">
                             <img src="{{ asset('images/marketing/david-kim.png') }}" alt="David Kim" class="img-fluid" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=David+Kim&background=random';">
                         </div>
                    </div>
                    <div class="p-4 pt-2">
                        <h5 class="fw-bold mb-1">David Kim</h5>
                        <p class="text-primary-custom small mb-3 fw-bold text-uppercase">Head of Product</p>
                        <p class="text-muted small mb-4">Focused on user experience and innovation.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-linkedin fa-lg"></i></a>
                            <a href="#" class="text-muted hover-primary"><i class="fab fa-twitter fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Member 4 -->
             <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-white rounded-4 shadow-sm text-center h-100 overflow-hidden hover-lift transition-all border border-light">
                    <div class="p-4 pb-0">
                         <div class="rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 120px; height: 120px; overflow: hidden;">
                             <img src="{{ asset('images/marketing/emily-davis.png') }}" alt="Emily Davis" class="img-fluid" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Emily+Davis&background=random';">
                         </div>
                    </div>
                    <div class="p-4 pt-2">
                        <h5 class="fw-bold mb-1">Emily Davis</h5>
                        <p class="text-primary-custom small mb-3 fw-bold text-uppercase">Customer Success</p>
                        <p class="text-muted small mb-4">Dedicated to helping your school succeed.</p>
                        <div class="d-flex justify-content-center gap-3">
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

@push('styles')
<style>
    .transform-rotate-3 { transform: rotate(3deg); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .blur-3xl { filter: blur(3rem); }
    .transition-all { transition: all 0.3s ease; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
</style>
@endpush
