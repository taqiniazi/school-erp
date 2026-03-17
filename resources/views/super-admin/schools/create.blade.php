<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Add School</h1>
            <a href="{{ route('super-admin.schools.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('super-admin.schools.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">School Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="campus_count" class="form-label">Campus Count <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control @error('campus_count') is-invalid @enderror" id="campus_count" name="campus_count" value="{{ old('campus_count') }}" required>
                                @error('campus_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="plan_id" class="form-label">Subscription Plan <span class="text-danger">*</span></label>
                                <select class="form-select @error('plan_id') is-invalid @enderror" id="plan_id" name="plan_id" required>
                                    <option value="" disabled {{ old('plan_id') ? '' : 'selected' }}>Select a plan</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ (string) old('plan_id') === (string) $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} ({{ number_format($plan->price, 2) }} / {{ ucfirst($plan->billing_cycle) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">Cash payment is recorded and the subscription is activated immediately.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">School Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="admin_name" class="form-label">Admin Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('admin_name') is-invalid @enderror" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required>
                                @error('admin_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="admin_email" class="form-label">Admin Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('admin_email') is-invalid @enderror" id="admin_email" name="admin_email" value="{{ old('admin_email', old('email')) }}" required>
                                @error('admin_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="admin_password" class="form-label">Admin Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('admin_password') is-invalid @enderror" id="admin_password" name="admin_password" required>
                                @error('admin_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tax_id" class="form-label">Tax ID</label>
                                <input type="text" class="form-control @error('tax_id') is-invalid @enderror" id="tax_id" name="tax_id" value="{{ old('tax_id') }}">
                                @error('tax_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            
                            <div class="col-md-6">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website') }}">
                                @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                       
                            <div class="col-md-6">
                                <label for="logo" class="form-label">School Logo <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/jpeg,image/png,image/jpg" required>
                                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook') }}" placeholder="https://facebook.com/your-page">
                                @error('facebook') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" class="form-control @error('twitter') is-invalid @enderror" id="twitter" name="twitter" value="{{ old('twitter') }}" placeholder="https://twitter.com/your-handle">
                                @error('twitter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/company/your-page">
                                @error('linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram') }}" placeholder="https://instagram.com/your-handle">
                                @error('instagram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <div class="d-row g-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create School
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
