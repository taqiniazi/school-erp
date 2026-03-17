﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Staff Profile') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('hr.staff.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold mb-2">Staff</label>
                            <select name="teacher_id" class="form-select" required>
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div>
                                <label class="form-label small fw-bold mb-2">Designation</label>
                                <input name="designation" class="form-control" />
                            </div>
                            <div>
                                <label class="form-label small fw-bold mb-2">Department</label>
                                <input name="department" class="form-control" />
                            </div>
                            <div>
                                <label class="form-label small fw-bold mb-2">Phone</label>
                                <input name="phone" class="form-control" />
                            </div>
                            <div>
                                <label class="form-label small fw-bold mb-2">Join Date</label>
                                <input type="date" name="join_date" class="form-control" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="form-label small fw-bold mb-2">Address</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                        <div class="mt-4">
                            <label class="form-label small fw-bold mb-2">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button class="btn btn-primary">Create</button>
                            <a href="{{ route('hr.staff.index') }}" class="btn btn-link text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






