@extends('layouts.marketing')

@section('title', 'Contact Us - School ERP')

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
                <h1 class="display-4 fw-bold mb-4">We'd Love to Hear From You</h1>
                <p class="lead mb-4 opacity-90">Have questions about our features, pricing, or need a custom solution? Reach out to us.</p>
            </div>
        </div>
    </div>
    <!-- Background Abstract Shapes -->
    <div class="position-absolute top-0 end-0 p-5 opacity-10">
        <i class="fas fa-paper-plane fa-10x"></i>
    </div>
</section>

<!-- Contact Form & Info -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4">Send us a message</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Your Name</label>
                                    <input type="text" class="form-control bg-light border-0 py-3" id="name" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">Email Address</label>
                                    <input type="email" class="form-control bg-light border-0 py-3" id="email" placeholder="john@example.com" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label fw-bold">Subject</label>
                                    <input type="text" class="form-control bg-light border-0 py-3" id="subject" placeholder="How can we help?" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-bold">Message</label>
                                    <textarea class="form-control bg-light border-0 py-3" id="message" rows="6" placeholder="Tell us more about your inquiry..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary-custom btn-lg w-100 py-3 fw-bold">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="h-100 d-flex flex-column gap-3">
                    <!-- Info Card 1 -->
                    <div class="card border-0 shadow-sm p-4">
                        <div class="card-body d-flex align-items-start">
                            <div class="icon-square bg-primary-custom text-white rounded-3 me-3 p-3 flex-shrink-0">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Visit Us</h5>
                                <p class="text-muted mb-0">123 Education Lane, Tech Park<br>Silicon Valley, CA 94025</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Card 2 -->
                    <div class="card border-0 shadow-sm p-4">
                        <div class="card-body d-flex align-items-start">
                            <div class="icon-square bg-success text-white rounded-3 me-3 p-3 flex-shrink-0">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Email Us</h5>
                                <p class="text-muted mb-0">support@schoolerp.com<br>sales@schoolerp.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Card 3 -->
                    <div class="card border-0 shadow-sm p-4">
                        <div class="card-body d-flex align-items-start">
                            <div class="icon-square bg-info text-white rounded-3 me-3 p-3 flex-shrink-0">
                                <i class="fas fa-phone-alt fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Call Us</h5>
                                <p class="text-muted mb-0">+1 (555) 123-4567<br>Mon-Fri, 9am-6pm EST</p>
                            </div>
                        </div>
                    </div>

                    <!-- Map Embed -->
                    <div class="card border-0 shadow-sm overflow-hidden flex-grow-1" style="min-height: 250px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3168.628236556408!2d-122.08625158469247!3d37.42206557982567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba02425dad8f%3A0x6c296c66619367e0!2sGoogleplex!5e0!3m2!1sen!2sus!4v1614123456789!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection




