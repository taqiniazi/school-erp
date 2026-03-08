@extends('layouts.auth-modern')

@section('title', 'Login')

@section('content')
    <div class="mb-4">
        <h3 class="auth-title">Welcome Back!</h3>
        <p class="auth-subtitle">Please sign in to your account.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label">Password</label>
            </div>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 form-check">
            <div class="row">
                <div class="col-md-6">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label text-secondary" for="remember_me">Remember me</label>
                </div>
                <div class="col-md-6 text-end">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">Forgot Password?</a>
                @endif
                </div>
            </div>
            
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-4">
            Sign In
        </button>

        <div class="text-center">
            <p class="text-secondary mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Sign Up</a></p>
        </div>
    </form>
@endsection
