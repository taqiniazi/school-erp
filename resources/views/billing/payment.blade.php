@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Complete Your Subscription</h1>
    </div>

    <div class="row">
        <!-- Plan Details -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Selected Plan</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold text-primary">{{ $plan->name }}</h4>
                        <div class="display-4 font-weight-bold">Rs. {{ number_format($plan->price) }}</div>
                        <div class="text-muted text-uppercase small">Per {{ ucfirst($plan->billing_cycle) }}</div>
                    </div>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Students
                            <span class="badge bg-primary rounded-pill">{{ $plan->max_students ?? 'Unlimited' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Teachers
                            <span class="badge bg-primary rounded-pill">{{ $plan->max_teachers ?? 'Unlimited' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Campuses
                            <span class="badge bg-primary rounded-pill">{{ $plan->max_campuses ?? 'Unlimited' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Storage
                            <span class="badge bg-primary rounded-pill">{{ $plan->storage_limit_mb ? $plan->storage_limit_mb . ' MB' : 'Unlimited' }}</span>
                        </li>
                    </ul>

                    <div class="text-center">
                        <a href="{{ route('billing.choose-plan') }}" class="btn btn-link">Change Plan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Options -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Methods</h6>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <ul class="nav nav-tabs" id="paymentTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="online-tab" data-bs-toggle="tab" data-bs-target="#online" type="button" role="tab" aria-controls="online" aria-selected="true">Online Payment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="false">Manual / Bank Transfer</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-4" id="paymentTabContent">
                        <!-- Online Payment -->
                        <div class="tab-pane fade show active" id="online" role="tabpanel" aria-labelledby="online-tab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <form action="{{ route('billing.payment.stripe', $plan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            <i class="fab fa-stripe fa-2x align-middle me-2"></i> Pay with Stripe
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <form action="{{ route('billing.payment.paypal', $plan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-lg btn-block text-white">
                                            <i class="fab fa-paypal fa-2x align-middle me-2"></i> Pay with PayPal
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-muted small mt-3">
                                <i class="fas fa-lock"></i> Your payment information is processed securely by our payment partners. We do not store your card details.
                            </p>
                        </div>

                        <!-- Manual Payment -->
                        <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                            <form action="{{ route('billing.payment.store', $plan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="payment_method_id" class="form-label">Select Payment Method</label>
                                    <select class="form-control @error('payment_method_id') is-invalid @enderror" id="payment_method_id" name="payment_method_id" required onchange="updateInstructions()">
                                        <option value="">-- Select Method --</option>
                                        @foreach($manualMethods as $method)
                                            <option value="{{ $method->id }}" data-instructions="{{ $method->details }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="alert alert-info d-none" id="payment-instructions">
                                    <strong>Instructions:</strong>
                                    <p class="mb-0" id="instruction-text"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="transaction_reference" class="form-label">Transaction ID / Reference Number</label>
                                    <input type="text" class="form-control @error('transaction_reference') is-invalid @enderror" id="transaction_reference" name="transaction_reference" value="{{ old('transaction_reference') }}" placeholder="e.g. TID-123456789">
                                    @error('transaction_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="proof_file" class="form-label">Upload Payment Proof (Screenshot/Receipt)</label>
                                    <input type="file" class="form-control @error('proof_file') is-invalid @enderror" id="proof_file" name="proof_file" accept="image/*,application/pdf" required>
                                    <div class="form-text">Accepted formats: JPG, PNG, PDF. Max size: 2MB.</div>
                                    @error('proof_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">Submit Payment Proof</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateInstructions() {
        const select = document.getElementById('payment_method_id');
        const instructionsDiv = document.getElementById('payment-instructions');
        const instructionText = document.getElementById('instruction-text');
        
        const selectedOption = select.options[select.selectedIndex];
        const instructions = selectedOption.getAttribute('data-instructions');
        
        if (instructions) {
            // Replace newlines with <br> for display
            instructionText.innerHTML = instructions.replace(/\n/g, '<br>');
            instructionsDiv.classList.remove('d-none');
        } else {
            instructionsDiv.classList.add('d-none');
        }
    }
</script>
@endpush
@endsection
