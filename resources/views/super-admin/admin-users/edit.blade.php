﻿@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Edit School Admin</h1>
        <a href="{{ route('super-admin.admin-users.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold">Edit Details: {{ $adminUser->name }}</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('super-admin.admin-users.update', $adminUser->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3 text-dark">School Information</h5>
                                <div class="mb-3">
                                    <label for="school_name" class="form-label">School Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="school_name" name="school_name" value="{{ old('school_name', optional($adminUser->school)->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', optional($adminUser->school)->address) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="campus_count" class="form-label">Number of Campuses</label>
                                    <input type="number" class="form-control" id="campus_count" name="campus_count" min="1" value="{{ old('campus_count', optional($adminUser->school)->campus_count) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3 text-dark">Admin Information</h5>
                                <div class="mb-3">
                                    <label for="admin_name" class="form-label">Admin Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="admin_name" name="admin_name" value="{{ old('admin_name', $adminUser->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $adminUser->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $adminUser->phone_number) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Only fill this if you want to change the password.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-row g-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save fa-sm text-white-50 me-2"></i>Update School Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endpush
@endsection


