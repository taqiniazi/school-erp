﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Payslip') }} #{{ $payslip->payslip_no }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <div class="lead fw-semibold">{{ $payslip->teacher->first_name }} {{ $payslip->teacher->last_name }}</div>
                            <div class="small text-secondary">Month: {{ date('Y-m', strtotime($payslip->pay_month)) }}</div>
                        </div>
                        <a href="{{ route('payroll.payslips.print', $payslip) }}" class="btn btn-success">Download PDF</a>
                    </div>

                    <div class="mb-4">
                        <div class="fw-semibold mb-2">Earnings</div>
                        <div class="table-responsive">
                            <table class="table table-bordered w-100 mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                        <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-3">Basic Salary</td>
                                        <td class="p-3 text-end">{{ number_format($payslip->basic_salary, 2) }}</td>
                                    </tr>
                                    @foreach($payslip->items->where('type', 'allowance') as $item)
                                        <tr>
                                            <td class="p-3">{{ $item->name }}</td>
                                            <td class="p-3 text-end">{{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="fw-semibold mb-2">Deductions</div>
                        <div class="table-responsive">
                            <table class="table table-bordered w-100 mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                        <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payslip->items->where('type', 'deduction') as $item)
                                        <tr>
                                            <td class="p-3">{{ $item->name }}</td>
                                            <td class="p-3 text-end">{{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="p-3" colspan="2">No deductions</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <div class="text-end">
                            <div>Total Allowances: <span class="fw-semibold">{{ number_format($payslip->total_allowances, 2) }}</span></div>
                            <div>Total Deductions: <span class="fw-semibold">{{ number_format($payslip->total_deductions, 2) }}</span></div>
                            <div class="lead">Net Salary: <span class="fw-bold">{{ number_format($payslip->net_salary, 2) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






