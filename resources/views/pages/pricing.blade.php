@extends('layouts.marketing')

@section('title', 'Pricing - School ERP')

@section('content')
<!-- Hero Section -->
 <style>
    .hero-section {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
    }
</style>
<section class="hero-section d-flex align-items-center bg-primary-custom text-white position-relative overflow-hidden" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Simple, Transparent Pricing</h1>
                <p class="lead mb-4 opacity-90">Choose the plan that fits your school's needs. No hidden fees, cancel anytime.</p>
                
                <!-- Pricing Toggle -->
                <div class="d-flex justify-content-center align-items-center mb-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="me-3 fw-bold">Monthly</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input p-2" type="checkbox" id="pricingToggle" style="width: 3.5em; height: 1.75em; cursor: pointer;">
                    </div>
                    <span class="ms-3 fw-bold">Yearly <span class="badge bg-warning text-dark ms-2 rounded-pill">-20%</span></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Background Abstract Shapes -->
    <div class="position-absolute top-0 start-0 p-5 opacity-10">
        <i class="fas fa-coins fa-10x"></i>
    </div>
</section>

<!-- Pricing Cards -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <!-- Standard Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm pricing-card">
                    <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                        <h4 class="fw-bold text-muted">Standard</h4>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h2 class="display-4 fw-bold mb-0">
                            $<span class="monthly-price">49</span><span class="yearly-price d-none">470</span>
                        </h2>
                        <p class="text-muted mb-4">per <span class="billing-period">month</span></p>
                        <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 250px;">
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Up to 500 Students</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> 50 Teachers</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Core Modules</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Email Support</li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary-custom w-100 py-2 fw-bold">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-primary-custom border-2 shadow pricing-card transform-scale">
                    <div class="position-absolute start-50 translate-middle" style="top:25px">
                        <span class="badge bg-primary-custom px-3 py-2 rounded-pill shadow-sm">Most Popular</span>
                    </div>
                    <div class="card-header bg-white border-0 pt-5 pb-0 text-center">
                        <h4 class="fw-bold text-primary-custom">Premium</h4>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h2 class="display-4 fw-bold mb-0">
                            $<span class="monthly-price">99</span><span class="yearly-price d-none">950</span>
                        </h2>
                        <p class="text-muted mb-4">per <span class="billing-period">month</span></p>
                        <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 250px;">
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Up to 2000 Students</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> 200 Teachers</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> All Modules</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Priority Support</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> 3 Campuses</li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('register') }}" class="btn btn-primary-custom w-100 py-2 fw-bold shadow">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm pricing-card">
                    <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                        <h4 class="fw-bold text-muted">Enterprise</h4>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h2 class="display-4 fw-bold mb-0">Custom</h2>
                        <p class="text-muted mb-4">tailored for you</p>
                        <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 250px;">
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Unlimited Students</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Unlimited Teachers</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Dedicated Account Manager</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Custom Integrations</li>
                            <li class="mb-3"><i class="fas fa-check text-success me-2"></i> On-premise Option</li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('pages.contact') }}" class="btn btn-outline-dark w-100 py-2 fw-bold">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comparison Table -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Compare Plans</h2>
            <p class="text-muted">Detailed feature comparison to help you decide.</p>
        </div>
        
        <div class="table-responsive shadow-sm rounded-3" data-aos="fade-up">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-primary-custom text-white">
                    <tr>
                        <th scope="col" class="py-3 ps-4" style="width: 30%;">Features</th>
                        <th scope="col" class="py-3 text-center" style="width: 23%;">Standard</th>
                        <th scope="col" class="py-3 text-center" style="width: 23%;">Premium</th>
                        <th scope="col" class="py-3 text-center" style="width: 23%;">Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="ps-4">Student Limit</th>
                        <td class="text-center">500</td>
                        <td class="text-center">2000</td>
                        <td class="text-center">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-4">Teacher Limit</th>
                        <td class="text-center">50</td>
                        <td class="text-center">200</td>
                        <td class="text-center">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-4">Storage</th>
                        <td class="text-center">10 GB</td>
                        <td class="text-center">50 GB</td>
                        <td class="text-center">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-4">Campuses</th>
                        <td class="text-center">1</td>
                        <td class="text-center">3</td>
                        <td class="text-center">Unlimited</td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-4">Core Modules</th>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-4">Advanced Reports</th>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <th scope="row" class="ps-4">API Access</th>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush shadow-sm rounded-3" id="pricingFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Can I switch plans later?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted">
                                Yes, you can upgrade or downgrade your plan at any time. Changes will take effect immediately, and billing will be adjusted on a pro-rata basis.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Is there a free trial?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted">
                                We offer a 14-day free trial for all plans. No credit card required. You can test all features before committing.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Do you offer discounts for non-profits?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted">
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
