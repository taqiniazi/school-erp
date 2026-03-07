@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-4x text-warning"></i>
                    </div>
                    
                    <h2 class="h3 mb-2 text-gray-800 font-weight-bold">Payment Verification Pending</h2>
                    
                    <p class="text-gray-600 mb-4 lead">
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
@endsection
