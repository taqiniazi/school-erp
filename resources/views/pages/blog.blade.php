@extends('layouts.marketing')

@section('title', 'Blog - School ERP')

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
                    <i class="fas fa-blog me-2"></i> Our Blog
                </span>
                <h1 class="display-3 fw-bold text-white mb-4">Insights & Updates</h1>
                <p class="lead text-light opacity-75 mb-0 fs-4">Stay informed about the latest trends in education technology, school management tips, and platform updates.</p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-6 bg-light position-relative">
    <div class="container position-relative" style="margin-top: -80px;">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Blog Post 1 -->
                <article class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5 hover-lift transition-all" data-aos="fade-up">
                    <div class="position-relative overflow-hidden" style="height: 400px;">
                        <img src="{{ asset('images/marketing/digital-classroom.jpg') }}" class="card-img-top h-100 w-100 object-fit-cover transition-transform hover-scale-img" alt="Digital Classroom" onerror="this.onerror=null; this.src='https://source.unsplash.com/random/800x600/?classroom,technology';">
                        <div class="position-absolute top-0 start-0 m-4">
                            <span class="badge bg-primary-custom text-white px-3 py-2 rounded-pill shadow-sm">EdTech</span>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <div class="d-flex align-items-center me-4">
                                <i class="far fa-calendar-alt me-2 text-primary"></i> Oct 15, 2023
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="far fa-user me-2 text-primary"></i> Sarah Chen
                            </div>
                        </div>
                        <h2 class="card-title fw-bold mb-3 h3">
                            <a href="#" class="text-decoration-none text-dark hover-primary transition-colors">The Future of Digital Classrooms</a>
                        </h2>
                        <p class="card-text text-muted mb-4 lh-lg">Explore how technology is reshaping the way students learn and teachers instruct. From interactive whiteboards to AI-driven personalized learning paths, the classroom of tomorrow is here today.</p>
                        <a href="#" class="btn btn-outline-primary-custom rounded-pill px-4 fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </article>

                <!-- Blog Post 2 -->
                <article class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5 hover-lift transition-all" data-aos="fade-up" data-aos-delay="100">
                    <div class="position-relative overflow-hidden" style="height: 400px;">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="card-img-top h-100 w-100 object-fit-cover transition-transform hover-scale-img" alt="School Administration" onerror="this.onerror=null; this.src='https://source.unsplash.com/random/800x600/?school,office';">
                        <div class="position-absolute top-0 start-0 m-4">
                            <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm">Management</span>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <div class="d-flex align-items-center me-4">
                                <i class="far fa-calendar-alt me-2 text-primary"></i> Sep 28, 2023
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="far fa-user me-2 text-primary"></i> Alex Morgan
                            </div>
                        </div>
                        <h2 class="card-title fw-bold mb-3 h3">
                            <a href="#" class="text-decoration-none text-dark hover-primary transition-colors">5 Tips for Efficient School Administration</a>
                        </h2>
                        <p class="card-text text-muted mb-4 lh-lg">Running a school involves juggling multiple responsibilities. Here are five actionable tips to streamline operations, reduce paperwork, and improve overall efficiency using modern ERP tools.</p>
                        <a href="#" class="btn btn-outline-primary-custom rounded-pill px-4 fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </article>

                <!-- Blog Post 3 -->
                <article class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5 hover-lift transition-all" data-aos="fade-up" data-aos-delay="200">
                    <div class="position-relative overflow-hidden" style="height: 400px;">
                        <img src="{{ asset('images/marketing/parent-communication.jpg') }}" class="card-img-top h-100 w-100 object-fit-cover transition-transform hover-scale-img" alt="Parent Communication" onerror="this.onerror=null; this.src='https://source.unsplash.com/random/800x600/?family,school';">
                        <div class="position-absolute top-0 start-0 m-4">
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">Communication</span>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <div class="d-flex align-items-center me-4">
                                <i class="far fa-calendar-alt me-2 text-primary"></i> Sep 10, 2023
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="far fa-user me-2 text-primary"></i> Emily Davis
                            </div>
                        </div>
                        <h2 class="card-title fw-bold mb-3 h3">
                            <a href="#" class="text-decoration-none text-dark hover-primary transition-colors">Bridging the Gap: Effective Parent-Teacher Communication</a>
                        </h2>
                        <p class="card-text text-muted mb-4 lh-lg">Strong communication between parents and teachers is key to student success. Learn how mobile apps and automated notifications can foster a collaborative environment.</p>
                        <a href="#" class="btn btn-outline-primary-custom rounded-pill px-4 fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </article>

                <!-- Pagination -->
                <nav aria-label="Page navigation" data-aos="fade-up">
                    <ul class="pagination justify-content-center gap-2">
                        <li class="page-item disabled">
                            <a class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 shadow-sm" href="#" style="width: 40px; height: 40px;"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 shadow-sm bg-primary-custom text-white" href="#" style="width: 40px; height: 40px;">1</a></li>
                        <li class="page-item"><a class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 shadow-sm text-muted hover-primary" href="#" style="width: 40px; height: 40px;">2</a></li>
                        <li class="page-item"><a class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 shadow-sm text-muted hover-primary" href="#" style="width: 40px; height: 40px;">3</a></li>
                        <li class="page-item">
                            <a class="page-link rounded-circle d-flex align-items-center justify-content-center border-0 shadow-sm text-muted hover-primary" href="#" style="width: 40px; height: 40px;"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Search Widget -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" data-aos="fade-left">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Search</h5>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 py-2" placeholder="Search posts...">
                                <button class="btn btn-primary-custom px-4" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" data-aos="fade-left" data-aos-delay="100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Categories</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <a href="#" class="d-flex justify-content-between align-items-center py-2 px-3 rounded-3 bg-light hover-bg-primary-light text-decoration-none text-dark transition-all">
                                        <span>EdTech</span>
                                        <span class="badge bg-white text-primary shadow-sm rounded-pill">12</span>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="d-flex justify-content-between align-items-center py-2 px-3 rounded-3 bg-light hover-bg-primary-light text-decoration-none text-dark transition-all">
                                        <span>Management</span>
                                        <span class="badge bg-white text-primary shadow-sm rounded-pill">8</span>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="d-flex justify-content-between align-items-center py-2 px-3 rounded-3 bg-light hover-bg-primary-light text-decoration-none text-dark transition-all">
                                        <span>Communication</span>
                                        <span class="badge bg-white text-primary shadow-sm rounded-pill">5</span>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="d-flex justify-content-between align-items-center py-2 px-3 rounded-3 bg-light hover-bg-primary-light text-decoration-none text-dark transition-all">
                                        <span>Product Updates</span>
                                        <span class="badge bg-white text-primary shadow-sm rounded-pill">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex justify-content-between align-items-center py-2 px-3 rounded-3 bg-light hover-bg-primary-light text-decoration-none text-dark transition-all">
                                        <span>Case Studies</span>
                                        <span class="badge bg-white text-primary shadow-sm rounded-pill">4</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="card border-0 shadow-lg rounded-4 bg-primary-custom text-white overflow-hidden position-relative" data-aos="fade-left" data-aos-delay="200">
                         <div class="position-absolute top-0 end-0 p-3 opacity-10">
                            <i class="fas fa-envelope-open-text fa-6x"></i>
                        </div>
                        <div class="card-body p-4 text-center position-relative z-1">
                            <h5 class="fw-bold mb-3">Subscribe to Newsletter</h5>
                            <p class="small opacity-90 mb-4">Get the latest updates delivered straight to your inbox.</p>
                            <form>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control border-0 text-dark" id="newsletterEmail" placeholder="name@example.com">
                                    <label for="newsletterEmail" class="text-dark">Email address</label>
                                </div>
                                <button type="submit" class="btn btn-light w-100 fw-bold text-primary-custom py-2 shadow-sm hover-scale">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection




