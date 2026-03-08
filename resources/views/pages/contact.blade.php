@extends('layouts.marketing')

@section('title', 'Contact Us - School ERP')

@section('content')

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" style="padding-top: 160px; padding-bottom: 100px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden">
        <div class="position-absolute top-0 end-0 bg-primary opacity-20 rounded-circle blur-3xl" style="width: 600px; height: 600px; transform: translate(30%, -30%); filter: blur(100px);"></div>
        <div class="position-absolute bottom-0 start-0 bg-secondary opacity-20 rounded-circle blur-3xl" style="width: 500px; height: 500px; transform: translate(-30%, 30%); filter: blur(80px);"></div>
    </div>

    <div class="container position-relative z-1">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8" data-aos="fade-up">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3 py-2 mb-4">
                    <i class="fas fa-envelope me-2"></i> Get in Touch
                </span>
                <h1 class="display-3 fw-bold text-white mb-4">Let's Start a Conversation</h1>
                <p class="lead text-light opacity-75 mb-0 fs-4">Have questions about our features, pricing, or need a custom solution? We're here to help you transform your school management.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-6 bg-light position-relative">
    <div class="container position-relative" style="margin-top: -80px;">
        <div class="row g-4">
            <!-- Contact Info Cards -->
            <div class="col-lg-4">
                <div class="row g-4">
                    <!-- Visit Us -->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-white rounded-4 shadow-sm p-4 h-100 hover-lift transition-all border border-light">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary me-3">
                                    <i class="fas fa-map-marker-alt fa-lg"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Visit Us</h5>
                            </div>
                            <p class="text-muted mb-0 ps-5 ms-2">123 Education Lane, Tech Park<br>Silicon Valley, CA 94025</p>
                        </div>
                    </div>

                    <!-- Email Us -->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-white rounded-4 shadow-sm p-4 h-100 hover-lift transition-all border border-light">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success me-3">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Email Us</h5>
                            </div>
                            <p class="text-muted mb-0 ps-5 ms-2">
                                <a href="mailto:support@schoolerp.com" class="text-decoration-none text-muted hover-primary">support@schoolerp.com</a><br>
                                <a href="mailto:sales@schoolerp.com" class="text-decoration-none text-muted hover-primary">sales@schoolerp.com</a>
                            </p>
                        </div>
                    </div>

                    <!-- Call Us -->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                        <div class="bg-white rounded-4 shadow-sm p-4 h-100 hover-lift transition-all border border-light">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info me-3">
                                    <i class="fas fa-phone-alt fa-lg"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Call Us</h5>
                            </div>
                            <p class="text-muted mb-0 ps-5 ms-2">
                                <a href="tel:+15551234567" class="text-decoration-none text-muted hover-primary">+1 (555) 123-4567</a><br>
                                <span class="small text-muted">Mon-Fri, 9am-6pm EST</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="bg-white rounded-4 shadow-lg p-4 p-md-5 h-100 border border-light">
                    <h3 class="fw-bold mb-2">Send us a message</h3>
                    <p class="text-muted mb-4">Fill out the form below and we'll get back to you within 24 hours.</p>
                    
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0" id="name" placeholder="John Doe" required>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control bg-light border-0" id="email" placeholder="name@example.com" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0" id="subject" placeholder="Subject" required>
                                    <label for="subject">Subject</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control bg-light border-0" id="message" placeholder="Leave a comment here" style="height: 150px" required></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary-custom btn-lg w-100 py-3 fw-bold shadow-sm hover-scale">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-0">
    <div class="w-100" style="height: 450px; filter: grayscale(20%);">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3168.628236556408!2d-122.08625158469247!3d37.42206557982567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba02425dad8f%3A0x6c296c66619367e0!2sGoogleplex!5e0!3m2!1sen!2sus!4v1614123456789!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

@endsection




