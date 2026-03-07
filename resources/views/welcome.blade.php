<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'School ERP') }} - Modern School Management System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #818cf8;
            --accent-color: #c7d2fe;
            --dark-color: #1e1b4b;
            --light-color: #f8fafc;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            color: #64748b;
            margin: 0 0.5rem;
            transition: color 0.2s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            padding: 8rem 0 5rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--primary-color), #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 2.5rem;
        }
        
        .hero-image {
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);
            transition: transform 0.5s ease;
        }
        
        .hero-image:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }

        /* Features Section */
        .section-padding {
            padding: 6rem 0;
        }
        
        .section-title {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
            border: 1px solid #f1f5f9;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: #e0e7ff;
            color: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Modules Section */
        .modules-section {
            background-color: #f8fafc;
        }
        
        .module-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .module-item i {
            color: var(--primary-color);
            margin-right: 10px;
        }

        /* Pricing Section */
        .pricing-card {
            border: none;
            border-radius: 1.5rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .pricing-card.popular {
            border: 2px solid var(--primary-color);
            transform: scale(1.05);
            z-index: 1;
        }
        
        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-10px);
        }
        
        .popular-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-bottom-left-radius: 1rem;
        }
        
        .price-tag {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-color);
        }
        
        .price-period {
            font-size: 1rem;
            color: #64748b;
            font-weight: 400;
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.5rem;
            border: 3px solid var(--accent-color);
        }

        /* Screenshots */
        .screenshot-item {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .screenshot-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4338ca 100%);
            color: white;
            padding: 5rem 0;
        }

        /* Footer */
        .footer {
            background-color: var(--dark-color);
            color: #94a3b8;
            padding: 4rem 0 2rem;
        }
        
        .footer-title {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 0.8rem;
            transition: color 0.2s;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .pricing-card.popular {
                transform: scale(1);
                margin: 2rem 0;
            }
            .pricing-card.popular:hover {
                transform: translateY(-10px);
            }
        }
    </style>
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
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="hero-title">Manage Your School With Confidence</h1>
                    <p class="hero-subtitle">The most comprehensive ERP solution for modern educational institutions. Streamline administration, enhance learning, and simplify communication.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">Start Free Trial</a>
                        <a href="#features" class="btn btn-outline-custom btn-lg">Learn More</a>
                    </div>
                    <div class="mt-4 text-muted small">
                        <i class="fas fa-check-circle text-success me-2"></i> No credit card required
                        <i class="fas fa-check-circle text-success ms-3 me-2"></i> 14-day free trial
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="School ERP Dashboard" class="img-fluid hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Why Choose Us?</h2>
                <p class="text-muted mt-3">Built with modern technology to serve the needs of future-ready schools.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <h4>Cloud Based</h4>
                        <p class="text-muted">Access your school data from anywhere, anytime. Secure and reliable cloud infrastructure.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Secure & Safe</h4>
                        <p class="text-muted">Role-based access control, data encryption, and regular backups keep your data safe.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Insightful Reports</h4>
                        <p class="text-muted">Generate comprehensive reports for attendance, finance, academics, and HR.</p>
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
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Modules Overview" class="img-fluid rounded-4 shadow-lg">
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
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Simple, Transparent Pricing</h2>
                <p class="text-muted mt-3">Choose the plan that fits your school's size and needs.</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <!-- Standard Plan -->
                <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-card h-100 p-4">
                        <h4 class="fw-bold mb-3">Standard</h4>
                        <div class="mb-3">
                            <span class="price-tag">Rs. 5k</span>
                            <span class="price-period">/month</span>
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
                        <div class="popular-badge">Most Popular</div>
                        <h4 class="fw-bold mb-3">Premium</h4>
                        <div class="mb-3">
                            <span class="price-tag">Rs. 15k</span>
                            <span class="price-period">/month</span>
                        </div>
                        <p class="text-muted small mb-4">Ideal for growing institutions.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 2000 Students</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 200 Teachers</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 3 Campuses</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> All Modules</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Priority Support</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom w-100">Get Started</a>
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
            </div>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Principal" class="testimonial-img">
                        <p class="text-muted fst-italic mb-3">"This ERP has completely transformed how we manage our school. The automated reports save us hours every week."</p>
                        <h5 class="fw-bold">Mr. Ahmed Khan</h5>
                        <small class="text-muted">Principal, City High School</small>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="testimonial-img">
                        <p class="text-muted fst-italic mb-3">"The fee management system is a lifesaver. Parents love the online payment options and instant receipts."</p>
                        <h5 class="fw-bold">Sarah Jenkins</h5>
                        <small class="text-muted">Admin Officer, St. Mary's</small>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/men/85.jpg" alt="Teacher" class="testimonial-img">
                        <p class="text-muted fst-italic mb-3">"Entering marks and attendance is so easy now. I can focus more on teaching and less on paperwork."</p>
                        <h5 class="fw-bold">Michael Chen</h5>
                        <small class="text-muted">Senior Teacher</small>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Screenshots Section -->
    <section id="screenshots" class="section-padding">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">See It in Action</h2>
                <p class="text-muted mt-3">A glimpse into our powerful and user-friendly interface.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="screenshot-item">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dashboard Overview" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="screenshot-item">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Profile" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="screenshot-item">
                        <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Reports & Analytics" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section text-center">
        <div class="container" data-aos="zoom-in">
            <h2 class="fw-bold mb-3">Ready to Transform Your School?</h2>
            <p class="lead mb-4">Join 500+ schools trusting our platform for their daily operations.</p>
            <a href="{{ route('register') }}" class="btn btn-light text-primary fw-bold btn-lg px-5 py-3">Get Started Today</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
                document.querySelector('.navbar').classList.remove('shadow-sm');
                document.querySelector('.navbar').style.padding = '1rem 0';
            }
        });
    </script>
</body>
</html>
