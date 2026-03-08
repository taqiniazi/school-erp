<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h2 class="h5 mb-0 fw-bold text-dark">
                            {{ __('Post New Notice') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('communication.notices.store') }}">
                            @csrf

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <input id="title" class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') }}" required autofocus />
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('Content') }}</label>
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="mb-3">
                                <label for="type" class="form-label">{{ __('Type') }}</label>
                                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
                                    <option value="general">General</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="event">Event Announcement</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Audience -->
                            <div class="mb-3">
                                <label for="audience_role" class="form-label">{{ __('Audience') }}</label>
                                <select id="audience_role" name="audience_role" class="form-select @error('audience_role') is-invalid @enderror">
                                    <option value="all">Everyone</option>
                                    <option value="Student">Students Only</option>
                                    <option value="Parent">Parents Only</option>
                                    <option value="Teacher">Teachers Only</option>
                                </select>
                                @error('audience_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Send Notification -->
                            <div class="mb-3 form-check">
                                <input id="send_notification" type="checkbox" class="form-check-input" name="send_notification" value="1">
                                <label class="form-check-label" for="send_notification">
                                    {{ __('Send SMS/Email Notification') }}
                                </label>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Post Notice') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
