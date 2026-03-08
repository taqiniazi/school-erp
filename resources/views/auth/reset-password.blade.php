@extends('layouts.auth-modern')

@section('title', 'Reset Password')

@section('content')
    <div class="mb-5">
        <h3 class="auth-title fw-bold">Reset Password</h3>
        <p class="text-muted">Create a new password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control bg-light border-0" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="name@example.com">
            <label for="email" class="text-muted">Email Address</label>
            @error('email')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control bg-light border-0" id="password" name="password" required autocomplete="new-password" placeholder="New Password">
            <label for="password" class="text-muted">Password</label>
            @error('password')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating mb-4">
            <input type="password" class="form-control bg-light border-0" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
            <label for="password_confirmation" class="text-muted">Confirm Password</label>
            @error('password_confirmation')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm hover-scale mb-4">
            Reset Password <i class="fas fa-lock ms-2"></i>
        </button>
    </form>
@endsection
