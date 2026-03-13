﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Billing History</h1>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            @if($payments->isEmpty())
                <p class="text-center text-muted">No billing history found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Reference / Invoice #</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Plan</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Amount</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td class="p-3 text-nowrap">
                                    {{ $payment->invoice_number ?? $payment->transaction_reference }}
                                </td>
                                <td class="p-3 text-nowrap">
                                    {{ $payment->invoice_date ? $payment->invoice_date->format('M d, Y') : $payment->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-3 text-nowrap">
                                    {{ $payment->plan->name }} ({{ ucfirst($payment->plan->billing_cycle) }})
                                </td>
                                <td class="p-3 text-nowrap">
                                    Rs. {{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="p-3 text-nowrap">
                                    @if($payment->status === 'approved')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="p-3 text-nowrap text-end">
                                    @if($payment->status === 'approved')
                                        <a href="{{ route('billing.invoice.download', $payment->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Invoice
                                        </a>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>

