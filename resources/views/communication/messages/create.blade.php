﻿x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-body py-3">
                        <h2 class="h5 mb-0 fw-bold text-dark">
                            {{ __('Compose Message') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('communication.messages.store') }}">
                            @csrf

                            <!-- Recipient -->
                            <div class="mb-3">
                                <label for="recipient_id" class="form-label">{{ __('To') }}</label>
                                <select id="recipient_id" name="recipient_id" class="form-select @error('recipient_id') is-invalid @enderror" required>
                                    <option value="">Select Recipient</option>
                                    @foreach($recipients as $recipient)
                                        <option value="{{ $recipient->id }}" {{ (old('recipient_id') == $recipient->id || request('recipient_id') == $recipient->id) ? 'selected' : '' }}>
                                            {{ $recipient->name }} ({{ $recipient->roles->pluck('name')->implode(', ') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('recipient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subject -->
                            <div class="mb-3">
                                <label for="subject" class="form-label">{{ __('Subject') }}</label>
                                <input id="subject" class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" value="{{ old('subject', request('subject')) }}" required autofocus />
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('Message') }}</label>
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="6" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> {{ __('Send Message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

