@extends('layouts.auth-modern')

@section('title', 'Register')

@section('content')
    <div class="mb-4">
        <h3 class="auth-title">Create Account</h3>
        <p class="auth-subtitle">Get started with your free account today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="Create a password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
            @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-4">
            Create Account
        </button>

        <div class="text-center">
            <p class="text-secondary mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Sign In</a></p>
        </div>
    </form>
@endsection
