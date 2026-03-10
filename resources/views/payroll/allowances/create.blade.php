﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Allowance') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('payroll.allowances.store') }}" method="POST">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Staff</label>
                                <select name="teacher_id" class="form-select" required>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-4 d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" name="is_percentage" id="is_percentage" class="form-check-input">
                                    <label for="is_percentage" class="form-check-label small fw-bold">Percentage</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Amount / %</label>
                                <input type="number" step="0.01" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                            <a href="{{ route('payroll.allowances.index') }}" class="btn btn-link text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





