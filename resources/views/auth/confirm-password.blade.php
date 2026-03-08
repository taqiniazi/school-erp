@extends('layouts.auth-modern')

@section('title', 'Confirm Password')

@section('content')
    <div class="mb-4">
        <h3 class="auth-title">Confirm Password</h3>
        <p class="auth-subtitle text-muted small">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-4">
            {{ __('Confirm') }}
        </button>
    </form>
@endsection
