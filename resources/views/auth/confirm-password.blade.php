@extends('layouts.auth-modern')

@section('title', 'Confirm Password')

@section('content')
    <div class="mb-5">
        <h3 class="auth-title fw-bold">Confirm Password</h3>
        <p class="text-muted">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm hover-scale mb-4">
            Confirm Password <i class="fas fa-check-circle ms-2"></i>
        </button>
    </form>
@endsection
