﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Salary Structure') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('payroll.salaries.store') }}" method="POST">
                        @csrf

                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Staff</label>
                                <select name="teacher_id" class="form-select" required>
                                    <option value="">Select Staff</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ (string) old('teacher_id') === (string) $t->id ? 'selected' : '' }}>
                                            {{ $t->user->name ?? ('Staff #' . $t->id) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Basic Salary</label>
                                <input type="number" step="0.01" min="0" name="basic_salary" value="{{ old('basic_salary') }}" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Effective From</label>
                                <input type="date" name="effective_from" value="{{ old('effective_from') }}" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold mb-2">Effective To</label>
                                <input type="date" name="effective_to" value="{{ old('effective_to') }}" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary fw-bold px-4 rounded">
                                Save
                            </button>
                            <a href="{{ route('payroll.salaries.index') }}" class="btn btn-link text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




