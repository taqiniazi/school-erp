﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Edit Expense') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 border-bottom">
                    <form action="{{ route('accounting.expense.update', $expense) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Financial Year</label>
                                <select name="financial_year_id" class="form-select" required>
                                    @foreach($years as $y)
                                        <option value="{{ $y->id }}" {{ $expense->financial_year_id == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Date</label>
                                <input type="date" name="date" value="{{ $expense->date->format('Y-m-d') }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Amount</label>
                                <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Category</label>
                                <input type="text" name="category" value="{{ $expense->category }}" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label small fw-bold text-dark">Description</label>
                                <input type="text" name="description" value="{{ $expense->description }}" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label small fw-bold text-dark">Reference</label>
                                <input type="text" name="reference" value="{{ $expense->reference }}" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                Update
                            </button>
                            <a href="{{ route('accounting.expense.index') }}" class="btn btn-link text-decoration-none text-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





