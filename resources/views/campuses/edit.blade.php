﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Edit Campus') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('campuses.update', $campus) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Campus Name')" />
                            <x-text-input id="name" class="d-block mt-1 w-100 form-control" type="text" name="name" :value="old('name', $campus->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" class="d-block mt-1 w-100 form-control" type="text" name="address" :value="old('address', $campus->address)" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" class="d-block mt-1 w-100 form-control" type="text" name="phone" :value="old('phone', $campus->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="d-block mt-1 w-100 form-control" type="email" name="email" :value="old('email', $campus->email)" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Is Main Campus -->
                        <div class="d-block mt-4">
                            <label for="is_main" class="d-inline-flex align-items-center">
                                <input id="is_main" type="checkbox" class="form-check-input" name="is_main" value="1" {{ old('is_main', $campus->is_main) ? 'checked' : '' }}>
                                <span class="ms-2 small text-secondary">{{ __('Is Main Campus?') }}</span>
                            </label>
                            <p class="small text-secondary mt-1">Checking this will unset any other main campus.</p>
                        </div>

                        <!-- Is Active -->
                        <div class="d-block mt-4">
                            <label for="is_active" class="d-inline-flex align-items-center">
                                <input id="is_active" type="checkbox" class="form-check-input" name="is_active" value="1" {{ old('is_active', $campus->is_active) ? 'checked' : '' }}>
                                <span class="ms-2 small text-secondary">{{ __('Is Active?') }}</span>
                            </label>
                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-4">
                            <a href="{{ route('campuses.index') }}" class="small text-secondary text-decoration-none hover-text-dark me-4">Cancel</a>
                            <x-primary-button class="ms-4">
                                {{ __('Update Campus') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




