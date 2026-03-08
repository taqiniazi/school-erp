@extends('layouts.auth-modern')

@section('title', 'Verify Email')

@section('content')
    <div class="mb-4">
        <h3 class="auth-title">Verify Email</h3>
        <p class="auth-subtitle text-muted small">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4" role="alert">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex flex-column gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary-custom w-100">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none text-secondary w-100">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
@endsection
