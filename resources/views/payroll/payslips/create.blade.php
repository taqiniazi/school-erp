﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Generate Payslip') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('payslips.store') }}" method="POST">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-dark">Staff</label>
                                <select name="teacher_id" class="form-select">
                                    <option value="">All</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ (string) old('teacher_id') === (string) $t->id ? 'selected' : '' }}>
                                            {{ optional($t->user)->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-dark">Pay Month</label>
                                <input type="month" name="pay_month" value="{{ old('pay_month') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                Generate
                            </button>
                            <a href="{{ route('payslips.index') }}" class="btn btn-link text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



