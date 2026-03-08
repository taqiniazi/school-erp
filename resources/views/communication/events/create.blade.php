<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h2 class="h5 mb-0 fw-bold text-dark">
                            {{ __('Schedule New Event') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('communication.events.store') }}">
                            @csrf

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Event Title') }}</label>
                                <input id="title" class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') }}" required autofocus />
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Start Date/Time -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">{{ __('Start Date & Time') }}</label>
                                    <input id="start_date" class="form-control @error('start_date') is-invalid @enderror" type="datetime-local" name="start_date" value="{{ old('start_date') }}" required />
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- End Date/Time -->
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">{{ __('End Date & Time') }}</label>
                                    <input id="end_date" class="form-control @error('end_date') is-invalid @enderror" type="datetime-local" name="end_date" value="{{ old('end_date') }}" />
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">{{ __('Location') }}</label>
                                <input id="location" class="form-control @error('location') is-invalid @enderror" type="text" name="location" value="{{ old('location') }}" placeholder="e.g. School Auditorium" />
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Schedule Event') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
