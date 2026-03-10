﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Income') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <form method="GET" class="d-flex align-items-end gap-2">
                            <div>
                                <label class="d-block small text-dark mb-1">Year</label>
                                <select name="financial_year_id" class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y->id }}" {{ request('financial_year_id') == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="d-block small text-dark mb-1">From</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm">
                            </div>
                            <div>
                                <label class="d-block small text-dark mb-1">To</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm">
                            </div>
                            <button class="btn btn-sm btn-light border">Filter</button>
                        </form>
                        <a href="{{ route('accounting.income.create') }}" class="btn btn-primary">
                            New Income
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Year</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Category</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Description</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Amount</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomes as $row)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $row->date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ $row->financialYear->name ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">{{ $row->category }}</td>
                                        <td class="p-3 text-nowrap">{{ $row->description }}</td>
                                        <td class="p-3 text-nowrap text-end fw-bold text-success">{{ number_format($row->amount, 2) }}</td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('accounting.income.edit', $row) }}" class="btn btn-sm btn-success text-decoration-none">Edit</a>
                                            <form action="{{ route('accounting.income.destroy', $row) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this income?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-link text-danger text-decoration-none">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $incomes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





