﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Add New Student') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container px-4">
            <div class="card shadow-sm">
                <div class="card-body p-4 text-dark">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h3 class="lead fw-medium text-dark mb-4 border-bottom pb-2">Personal Information</h3>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="first_name" class="d-block small fw-medium text-dark">First Name *</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="mt-1 form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="d-block small fw-medium text-dark">Last Name *</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="mt-1 form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="dob" class="d-block small fw-medium text-dark">Date of Birth *</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required class="mt-1 form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="gender" class="d-block small fw-medium text-dark">Gender *</label>
                                    <select name="gender" id="gender" required class="mt-1 form-select">
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="photo" class="d-block small fw-medium text-dark">Photo</label>
                                    <input type="file" name="photo" id="photo" class="mt-1 form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="mb-4">
                            <h3 class="lead fw-medium text-dark mb-4 border-bottom pb-2">Academic Information</h3>
                            <div class="row row-cols-1 row-cols-md-3 g-4">
                                <div class="col">
                                    <label for="admission_number" class="d-block small fw-medium text-dark">Admission Number *</label>
                                    <input type="text" name="admission_number" id="admission_number" value="{{ old('admission_number') }}" required class="mt-1 form-control">
                                </div>
                                <div class="col">
                                    <label for="admission_date" class="d-block small fw-medium text-dark">Admission Date *</label>
                                    <input type="date" name="admission_date" id="admission_date" value="{{ old('admission_date') }}" required class="mt-1 form-control">
                                </div>
                                <div class="col">
                                    <label for="roll_number" class="d-block small fw-medium text-dark">Roll Number</label>
                                    <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number') }}" class="mt-1 form-control">
                                </div>
                                <div class="col">
                                    <label for="campus_id" class="d-block small fw-medium text-dark">Campus</label>
                                    <select name="campus_id" id="campus_id" class="mt-1 form-select">
                                        <option value="">Select Campus</option>
                                        @foreach($campuses as $campus)
                                            <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="school_class_id" class="d-block small fw-medium text-dark">Class *</label>
                                    <select name="school_class_id" id="school_class_id" required class="mt-1 form-select">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="section_id" class="d-block small fw-medium text-dark">Section *</label>
                                    <select name="section_id" id="section_id" required disabled class="mt-1 form-select bg-light">
                                        <option value="">Select Class First</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h3 class="lead fw-medium text-dark mb-4 border-bottom pb-2">Contact Information</h3>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="address" class="d-block small fw-medium text-dark">Address *</label>
                                    <textarea name="address" id="address" rows="3" required class="mt-1 form-control"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="d-block small fw-medium text-dark">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="d-block small fw-medium text-dark">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 form-control">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('students.index') }}" class="me-3 btn btn-light border text-dark">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary text-white">
                                Save Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




