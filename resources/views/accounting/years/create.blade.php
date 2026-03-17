﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Financial Year') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('financial-years.store') }}" method="POST">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="mb-4">
                                <label for="name" class="form-label small fw-bold mb-2">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="start_date" class="form-label small fw-bold mb-2">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="end_date" class="form-label small fw-bold mb-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                            <div class="mb-4 d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" name="is_current" id="is_current" class="form-check-input me-2">
                                    <label for="is_current" class="form-check-label small fw-bold">Set as current</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary fw-bold px-4 rounded">
                                Save
                            </button>
                            <a href="{{ route('financial-years.index') }}" class="btn btn-link text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





