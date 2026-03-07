@extends('layouts.auth-modern')

@section('title', 'Forgot Password')

@section('content')
    <div class="mb-4">
        <h3 class="auth-title">Reset Password</h3>
        <p class="auth-subtitle">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-4">
            Email Password Reset Link
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-secondary text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </form>
@endsection
