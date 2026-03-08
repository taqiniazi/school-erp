@extends('layouts.auth-modern')

@section('title', 'Register')

@section('content')
    <div class="mb-5">
        <h3 class="auth-title fw-bold">Create Account</h3>
        <p class="text-muted">Get started with your free account today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control bg-light border-0" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            <label for="name" class="text-muted">Full Name</label>
            @error('name')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control bg-light border-0" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com">
            <label for="email" class="text-muted">Email Address</label>
            @error('email')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control bg-light border-0" id="password" name="password" required autocomplete="new-password" placeholder="Create a password">
            <label for="password" class="text-muted">Password</label>
            @error('password')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating mb-4">
            <input type="password" class="form-control bg-light border-0" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
            <label for="password_confirmation" class="text-muted">Confirm Password</label>
            @error('password_confirmation')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm hover-scale mb-4">
            Create Account <i class="fas fa-user-plus ms-2"></i>
        </button>

        <div class="text-center">
            <p class="text-muted mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none hover-primary">Log In</a></p>
        </div>
    </form>
@endsection
