@extends('layouts.auth-modern')

@section('title', 'Verify Email')

@section('content')
    <div class="mb-5">
        <h3 class="auth-title fw-bold">Verify Email</h3>
        <p class="text-muted">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>A new verification link has been sent to the email address you provided during registration.</div>
        </div>
    @endif

    <div class="d-grid gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm hover-scale">
                Resend Verification Email <i class="fas fa-envelope ms-2"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100 py-2 fw-semibold border-0">
                <i class="fas fa-sign-out-alt me-2"></i> Log Out
            </button>
        </form>
    </div>
@endsection


