@extends('layouts.marketing')

@section('title', 'Pricing - School ERP')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center position-relative overflow-hidden">
    <!-- Background Abstract Shapes -->
    <div class="hero-shape-1"></div>
    <div class="hero-shape-3"></div>
    
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-4 fw-bold">
                    <i class="fas fa-tag me-2"></i> Flexible Plans
                </span>
                <h1 class="hero-title mb-4">
                    Simple, Transparent <br>
                    <span class="text-gradient">Pricing</span>
                </h1>
                <p class="hero-subtitle mx-auto mb-5">
                    Choose the plan that fits your school's needs. No hidden fees, cancel anytime.
                </p>
                
                <!-- Pricing Toggle -->
                <div class="d-flex justify-content-center align-items-center mb-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="me-3 fw-bold text-muted">Monthly</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input p-2" type="checkbox" id="pricingToggle" style="width: 3.5em; height: 1.75em; cursor: pointer;">
                    </div>
                    <span class="ms-3 fw-bold text-dark">Yearly <span class="badge bg-warning text-dark ms-2 rounded-pill shadow-sm">-20%</span></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Cards -->
<section class="section-padding bg-light position-relative">
    <div class="container">
        <div class="row g-4 justify-content-center align-items-center">
            <!-- Standard Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="pricing-card h-100 bg-white shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 text-center">
                        <h4 class="fw-bold text-muted mb-0">Standard</h4>
                        <div class="my-4">
                            <span class="price-tag">$<span class="monthly-price">49</span><span class="yearly-price d-none">470</span></span>
                            <span class="price-period">/ <span class="billing-period">mo</span></span>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0 d-flex flex-column">
                        <p class="text-center text-muted mb-4">Perfect for small schools just starting out.</p>
                        <ul class="pricing-features list-unstyled mb-4">
                            <li><i class="fas fa-check-circle"></i> <span>Up to <strong>500</strong> Students</span></li>
                            <li><i class="fas fa-check-circle"></i> <span><strong>50</strong> Teachers</span></li>
                            <li><i class="fas fa-check-circle"></i> <span>Core Modules</span></li>
                            <li><i class="fas fa-check-circle"></i> <span>Email Support</span></li>
                            <li class="text-muted opacity-50"><i class="fas fa-times-circle text-secondary"></i> <span>Advanced Reporting</span></li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('register') }}" class="btn btn-outline-custom w-100 py-3 fw-bold rounded-3">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-card popular bg-white shadow-lg border-primary-custom position-relative">
                    <div class="position-absolute top-0 start-50 translate-middle-x mt-n3">
                        <span class="badge bg-primary-custom px-3 py-2 rounded-pill shadow-sm text-uppercase small fw-bold tracking-wide">Most Popular</span>
                    </div>
                    <div class="card-header bg-transparent border-0 pt-5 pb-0 text-center">
                        <h4 class="fw-bold text-primary-custom mb-0">Premium</h4>
                        <div class="my-4">
                            <span class="price-tag text-primary-custom">$<span class="monthly-price">99</span><span class="yearly-price d-none">950</span></span>
                            <span class="price-period">/ <span class="billing-period">mo</span></span>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0 d-flex flex-column">
                        <p class="text-center text-muted mb-4">For growing schools that need more power.</p>
                        <ul class="pricing-features list-unstyled mb-4">
                            <li><i class="fas fa-check-circle text-primary-custom"></i> <span>Up to <strong>2000</strong> Students</span></li>
                            <li><i class="fas fa-check-circle text-primary-custom"></i> <span><strong>200</strong> Teachers</span></li>
                            <li><i class="fas fa-check-circle text-primary-custom"></i> <span>All Modules</span></li>
                            <li><i class="fas fa-check-circle text-primary-custom"></i> <span>Priority Support</span></li>
                            <li><i class="fas fa-check-circle text-primary-custom"></i> <span>3 Campuses</span></li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('register') }}" class="btn btn-primary-custom w-100 py-3 fw-bold rounded-3 shadow-md hover-lift">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="pricing-card h-100 bg-white shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 text-center">
                        <h4 class="fw-bold text-muted mb-0">Enterprise</h4>
                        <div class="my-4">
                            <span class="display-5 fw-bold text-dark">Custom</span>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0 d-flex flex-column">
                        <p class="text-center text-muted mb-4">Tailored solutions for large institutions.</p>
                        <ul class="pricing-features list-unstyled mb-4">
                            <li><i class="fas fa-check-circle"></i> <span><strong>Unlimited</strong> Students</span></li>
                            <li><i class="fas fa-check-circle"></i> <span><strong>Unlimited</strong> Teachers</span></li>
                            <li><i class="fas fa-check-circle"></i> <span>Dedicated Manager</span></li>
                            <li><i class="fas fa-check-circle"></i> <span>Custom Integrations</span></li>
                            <li><i class="fas fa-check-circle"></i> <span>On-premise Option</span></li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('pages.contact') }}" class="btn btn-outline-dark w-100 py-3 fw-bold rounded-3">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comparison Table -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold display-6">Compare Plans</h2>
            <p class="text-muted">Detailed feature comparison to help you decide.</p>
        </div>
        
        <div class="table-responsive shadow-lg rounded-4 overflow-hidden" data-aos="fade-up">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="bg-primary-custom text-white">
                    <tr>
                        <th scope="col" class="py-4 ps-5 border-0" style="width: 30%;">Features</th>
                        <th scope="col" class="py-4 text-center border-0" style="width: 23%;">Standard</th>
                        <th scope="col" class="py-4 text-center border-0" style="width: 23%;">Premium</th>
                        <th scope="col" class="py-4 text-center border-0" style="width: 23%;">Enterprise</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">Student Limit</th>
                        <td class="text-center py-3 fw-bold text-dark">500</td>
                        <td class="text-center py-3 fw-bold text-primary-custom bg-primary-custom bg-opacity-10">2000</td>
                        <td class="text-center py-3 fw-bold text-dark">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">Teacher Limit</th>
                        <td class="text-center py-3 fw-bold text-dark">50</td>
                        <td class="text-center py-3 fw-bold text-primary-custom bg-primary-custom bg-opacity-10">200</td>
                        <td class="text-center py-3 fw-bold text-dark">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">Storage</th>
                        <td class="text-center py-3 text-muted">10 GB</td>
                        <td class="text-center py-3 text-dark bg-primary-custom bg-opacity-10">50 GB</td>
                        <td class="text-center py-3 text-dark">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">Campuses</th>
                        <td class="text-center py-3 text-muted">1</td>
                        <td class="text-center py-3 text-dark bg-primary-custom bg-opacity-10">3</td>
                        <td class="text-center py-3 text-dark">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">Core Modules</th>
                        <td class="text-center py-3"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center py-3 bg-primary-custom bg-opacity-10"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center py-3"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">Advanced Reports</th>
                        <td class="text-center py-3"><i class="fas fa-times text-muted opacity-25"></i></td>
                        <td class="text-center py-3 bg-primary-custom bg-opacity-10"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center py-3"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-5 py-3 text-secondary">API Access</th>
                        <td class="text-center py-3"><i class="fas fa-times text-muted opacity-25"></i></td>
                        <td class="text-center py-3 bg-primary-custom bg-opacity-10"><i class="fas fa-times text-muted opacity-25"></i></td>
                        <td class="text-center py-3"><i class="fas fa-check text-success"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden bg-white" id="pricingFaq">
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Can I switch plans later?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted px-4 pb-4 pt-0">
                                Yes, you can upgrade or downgrade your plan at any time. Changes will take effect immediately, and billing will be adjusted on a pro-rata basis.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Is there a free trial?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted px-4 pb-4 pt-0">
                                We offer a 14-day free trial for all plans. No credit card required. You can test all features before committing.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Do you offer discounts for non-profits?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted px-4 pb-4 pt-0">
                                Yes, we offer special pricing for non-profit educational institutions. Please contact our sales team for more details.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pricingToggle = document.getElementById('pricingToggle');
        const monthlyPrices = document.querySelectorAll('.monthly-price');
        const yearlyPrices = document.querySelectorAll('.yearly-price');
        const billingPeriods = document.querySelectorAll('.billing-period');

        if(pricingToggle) {
            pricingToggle.addEventListener('change', function() {
                const isYearly = this.checked;
                
                monthlyPrices.forEach(price => {
                    price.classList.toggle('d-none', isYearly);
                });
                
                yearlyPrices.forEach(price => {
                    price.classList.toggle('d-none', !isYearly);
                });
                
                billingPeriods.forEach(period => {
                    period.textContent = isYearly ? 'year' : 'month';
                });
            });
        }
    });
</script>
@endpush
