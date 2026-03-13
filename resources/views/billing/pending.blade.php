<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Payment Verification Pending</h1>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-clock fa-4x text-warning"></i>
                        </div>

                        <h2 class="h3 mb-2 text-dark fw-bold">Payment Verification Pending</h2>

                        <p class="text-secondary mb-4 lead">
                            Thank you for your payment! We have received your subscription request and payment proof.
                        </p>

                        <div class="alert alert-info mb-4 text-start">
                            <i class="fas fa-info-circle me-2"></i>
                            Our team is currently verifying your payment. This process usually takes 1-2 hours. You will receive an email notification once your subscription is active.
                        </div>

                        <a href="{{ route('billing.payment.history') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-history me-2"></i> View Payment History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
