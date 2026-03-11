﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Profit & Loss') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="GET" class="mb-4">
                        <div class="d-flex align-items-end gap-2">
                            <div>
                                <label class="form-label small text-dark mb-1">Financial Year</label>
                                <select name="financial_year_id" class="form-select form-select-sm">
                                    <option value="">Select</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y->id }}" {{ optional($selectedYear)->id == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-sm btn-light border">Apply</button>
                        </div>
                    </form>

                    <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
                        <div class="col">
                            <div class="p-4 alert alert-success border-0 rounded-3 mb-0">
                                <div class="small text-success-emphasis">Total Income</div>
                                <div class="h3 fw-bold text-success">{{ number_format($totalIncome, 2) }}</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-4 alert alert-danger border-0 rounded-3 mb-0">
                                <div class="small text-danger-emphasis">Total Expenses</div>
                                <div class="h3 fw-bold text-danger">{{ number_format($totalExpense, 2) }}</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-4 alert alert-primary border-0 rounded-3 mb-0">
                                <div class="small text-primary-emphasis">Net</div>
                                <div class="h3 fw-bold {{ $net >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($net, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <h3 class="lead fw-medium mb-3">Monthly Breakdown</h3>
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Month</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Income</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Expenses</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthly as $m)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $m->ym }}</td>
                                        <td class="p-3 text-nowrap text-end text-success">{{ number_format($m->income, 2) }}</td>
                                        <td class="p-3 text-nowrap text-end text-danger">{{ number_format($m->expense, 2) }}</td>
                                        <td class="p-3 text-nowrap text-end fw-bold {{ $m->net >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($m->net, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





