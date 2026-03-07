@extends('layouts.marketing')

@section('title', 'Blog - School ERP')

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
                <h1 class="display-4 fw-bold mb-4">Latest Insights & Updates</h1>
                <p class="lead mb-4 opacity-90">Stay informed about the latest trends in education technology and school management.</p>
            </div>
        </div>
    </div>
    <!-- Background Abstract Shapes -->
    <div class="position-absolute top-0 start-0 p-5 opacity-10">
        <i class="fas fa-newspaper fa-10x"></i>
    </div>
</section>

<!-- Blog Content -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Blog Post 1 -->
                <article class="card border-0 shadow-sm mb-5" data-aos="fade-up">
                    <img src="https://images.unsplash.com/photo-1427504746696-ea3093e26d2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Digital Classroom" style="height: 400px; object-fit: cover;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <span class="me-3"><i class="far fa-calendar-alt me-2"></i> Oct 15, 2023</span>
                            <span class="me-3"><i class="far fa-user me-2"></i> Sarah Chen</span>
                            <span class="badge bg-primary-subtle text-primary-custom rounded-pill">EdTech</span>
                        </div>
                        <h2 class="card-title fw-bold mb-3"><a href="#" class="text-decoration-none text-dark hover-primary">The Future of Digital Classrooms</a></h2>
                        <p class="card-text text-muted mb-4">Explore how technology is reshaping the way students learn and teachers instruct. From interactive whiteboards to AI-driven personalized learning paths, the classroom of tomorrow is here today.</p>
                        <a href="#" class="btn btn-outline-primary-custom fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </article>

                <!-- Blog Post 2 -->
                <article class="card border-0 shadow-sm mb-5" data-aos="fade-up" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="School Administration" style="height: 400px; object-fit: cover;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <span class="me-3"><i class="far fa-calendar-alt me-2"></i> Sep 28, 2023</span>
                            <span class="me-3"><i class="far fa-user me-2"></i> Alex Morgan</span>
                            <span class="badge bg-success-subtle text-success rounded-pill">Management</span>
                        </div>
                        <h2 class="card-title fw-bold mb-3"><a href="#" class="text-decoration-none text-dark hover-primary">5 Tips for Efficient School Administration</a></h2>
                        <p class="card-text text-muted mb-4">Running a school involves juggling multiple responsibilities. Here are five actionable tips to streamline operations, reduce paperwork, and improve overall efficiency using modern ERP tools.</p>
                        <a href="#" class="btn btn-outline-primary-custom fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </article>

                <!-- Blog Post 3 -->
                <article class="card border-0 shadow-sm mb-5" data-aos="fade-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Parent Communication" style="height: 400px; object-fit: cover;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <span class="me-3"><i class="far fa-calendar-alt me-2"></i> Sep 10, 2023</span>
                            <span class="me-3"><i class="far fa-user me-2"></i> Emily Davis</span>
                            <span class="badge bg-warning-subtle text-warning rounded-pill">Communication</span>
                        </div>
                        <h2 class="card-title fw-bold mb-3"><a href="#" class="text-decoration-none text-dark hover-primary">Bridging the Gap: Effective Parent-Teacher Communication</a></h2>
                        <p class="card-text text-muted mb-4">Strong communication between parents and teachers is key to student success. Learn how mobile apps and automated notifications can foster a collaborative environment.</p>
                        <a href="#" class="btn btn-outline-primary-custom fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </article>

                <!-- Pagination -->
                <nav aria-label="Page navigation" data-aos="fade-up">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link bg-primary-custom border-primary-custom" href="#">1</a></li>
                        <li class="page-item"><a class="page-link text-primary-custom" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-primary-custom" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link text-primary-custom" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Search Widget -->
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-left">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Search</h5>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0" placeholder="Search posts...">
                                <button class="btn btn-primary-custom" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-left" data-aos-delay="100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Categories</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary d-flex justify-content-between">EdTech <span class="badge bg-light text-dark rounded-pill">12</span></a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary d-flex justify-content-between">Management <span class="badge bg-light text-dark rounded-pill">8</span></a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary d-flex justify-content-between">Communication <span class="badge bg-light text-dark rounded-pill">5</span></a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary d-flex justify-content-between">Product Updates <span class="badge bg-light text-dark rounded-pill">3</span></a></li>
                                <li><a href="#" class="text-decoration-none text-muted hover-primary d-flex justify-content-between">Case Studies <span class="badge bg-light text-dark rounded-pill">4</span></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="card border-0 shadow-sm bg-primary-custom text-white" data-aos="fade-left" data-aos-delay="200">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold mb-3">Subscribe to Newsletter</h5>
                            <p class="small opacity-75 mb-3">Get the latest updates delivered straight to your inbox.</p>
                            <form>
                                <input type="email" class="form-control border-0 mb-3" placeholder="Enter your email">
                                <button type="submit" class="btn btn-light w-100 fw-bold text-primary-custom">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
