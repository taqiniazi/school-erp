@extends('layouts.auth-modern')

@section('title', 'Forgot Password')

@section('content')
    <div class="mb-5">
        <h3 class="auth-title fw-bold">Reset Password</h3>
        <p class="text-muted">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-floating mb-4">
            <input type="email" class="form-control bg-light border-0" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
            <label for="email" class="text-muted">Email Address</label>
            @error('email')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm hover-scale mb-4">
            Email Password Reset Link <i class="fas fa-paper-plane ms-2"></i>
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-muted text-decoration-none hover-primary fw-semibold">
                <i class="fas fa-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </form>
@endsection
