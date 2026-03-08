@extends('layouts.auth-modern')

@section('title', 'Login')

@section('content')
    <div class="mb-5">
        <h3 class="auth-title fw-bold">Welcome Back!</h3>
        <p class="text-muted">Please sign in to continue to your dashboard.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control bg-light border-0" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            <label for="email" class="text-muted">Email Address</label>
            @error('email')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating mb-4">
            <input type="password" class="form-control bg-light border-0" id="password" name="password" required autocomplete="current-password" placeholder="Password">
            <label for="password" class="text-muted">Password</label>
            @error('password')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input border-secondary" id="remember_me" name="remember">
                <label class="form-check-label text-muted user-select-none" for="remember_me">Remember me</label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-semibold small hover-primary">Forgot Password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm hover-scale mb-4">
            Sign In <i class="fas fa-arrow-right ms-2"></i>
        </button>

        <div class="text-center">
            <p class="text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none hover-primary">Sign Up</a></p>
        </div>
    </form>
@endsection


