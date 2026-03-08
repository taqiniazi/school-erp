@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Create New Plan</h1>
        <a href="{{ route('super-admin.plans.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Plan Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('super-admin.plans.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">Plan Code (Unique) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                </div>
                                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="billing_cycle" class="form-label">Billing Cycle <span class="text-danger">*</span></label>
                                <select class="form-select @error('billing_cycle') is-invalid @enderror" id="billing_cycle" name="billing_cycle" required>
                                    <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('billing_cycle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="text-primary mb-3">Plan Limits (Leave empty for Unlimited)</h6>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="max_students" class="form-label">Max Students</label>
                                <input type="number" class="form-control @error('max_students') is-invalid @enderror" id="max_students" name="max_students" value="{{ old('max_students') }}">
                                @error('max_students') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="max_teachers" class="form-label">Max Teachers</label>
                                <input type="number" class="form-control @error('max_teachers') is-invalid @enderror" id="max_teachers" name="max_teachers" value="{{ old('max_teachers') }}">
                                @error('max_teachers') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="max_campuses" class="form-label">Max Campuses</label>
                                <input type="number" class="form-control @error('max_campuses') is-invalid @enderror" id="max_campuses" name="max_campuses" value="{{ old('max_campuses', 1) }}">
                                @error('max_campuses') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="storage_limit_mb" class="form-label">Storage Limit (MB)</label>
                            <input type="number" class="form-control @error('storage_limit_mb') is-invalid @enderror" id="storage_limit_mb" name="storage_limit_mb" value="{{ old('storage_limit_mb') }}">
                            <small class="text-muted">1024 MB = 1 GB</small>
                            @error('storage_limit_mb') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-primary mb-3">Modules & Features</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Allowed Modules</label>
                            <div class="row">
                                @foreach($modules as $key => $label)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_modules[]" value="{{ $key }}" id="module_{{ $key }}" {{ in_array($key, old('allowed_modules', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="module_{{ $key }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label fw-bold">Plan Features (One per line)</label>
                            <textarea class="form-control @error('features') is-invalid @enderror" id="features" name="features" rows="5" placeholder="Up to 500 Students&#10;Up to 50 Teachers&#10;Core Modules&#10;Email Support">{{ old('features') }}</textarea>
                            <small class="text-muted">These features will be displayed on the pricing page.</small>
                            @error('features') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active (Visible for subscription)</label>
                        </div>

                        <div class="d-row g-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


