﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Payslips') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <form method="GET" class="d-flex align-items-end gap-2">
                            <div>
                                <label class="d-block small text-dark">Staff</label>
                                <select name="teacher_id" class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>{{ optional($t->user)->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="d-block small text-dark">Month</label>
                                <input type="month" name="month" value="{{ request('month') }}" class="form-control form-control-sm">
                            </div>
                            <button class="btn btn-sm btn-light border">Filter</button>
                        </form>
                        <a href="{{ route('payslips.create') }}" class="btn btn-primary">Generate</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Payslip #</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Staff</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Month</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Net Salary</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payslips as $p)
                                    <tr>
                                        <td class="p-3 align-middle text-nowrap">{{ $p->payslip_no }}</td>
                                        <td class="p-3 align-middle text-nowrap">{{ optional(optional($p->teacher)->user)->name }}</td>
                                        <td class="p-3 align-middle text-nowrap">{{ date('Y-m', strtotime($p->pay_month)) }}</td>
                                        <td class="p-3 align-middle text-nowrap">{{ number_format($p->net_salary, 2) }}</td>
                                        <td class="p-3 align-middle text-nowrap text-end">
                                            <a href="{{ route('payslips.show', $p) }}" class="btn btn-sm btn-outline-info me-2">View</a>
                                            <a href="{{ route('payslips.print', $p) }}" class="btn btn-sm btn-outline-success me-2">PDF</a>
                                            <form action="{{ route('payslips.destroy', $p) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this payslip?')">Delete</button>
                                            </form>
                                        </td>
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



