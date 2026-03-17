﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Financial Reports') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    
                    <form method="GET" action="{{ route('reports.financial') }}" class="mb-4 row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                            <input id="start_date" class="form-control" type="date" name="start_date" value="{{ $startDate }}" required />
                        </div>

                        <div class="col-md-4">
                            <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                            <input id="end_date" class="form-control" type="date" name="end_date" value="{{ $endDate }}" required />
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100" name="generate" value="1">
                                {{ __('Generate Report') }}
                            </button>
                        </div>
                    </form>

                    @if($payments->isNotEmpty())
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="lead fw-semibold">
                                Total Collection: ${{ number_format($totalCollection, 2) }}
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-danger text-white">
                                    Export PDF
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="btn btn-success text-white">
                                    Export Excel
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover w-100 mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Payment ID</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Amount</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $payment->id }}</td>
                                            <td class="p-3 text-nowrap small fw-medium text-dark">
                                                {{ $payment->feeInvoice->student->first_name ?? 'N/A' }} {{ $payment->feeInvoice->student->last_name ?? '' }}
                                            </td>
                                            <td class="p-3 text-nowrap small text-secondary">
                                                {{ optional($payment->feeInvoice->student->schoolClass)->name ?? 'N/A' }}
                                            </td>
                                            <td class="p-3 text-nowrap small text-dark">${{ number_format($payment->amount, 2) }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $payment->payment_date }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ ucfirst($payment->payment_method) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">
                            <p class="mb-0">No payment records found for the selected period.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



