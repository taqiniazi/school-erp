@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Billing History</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Payment History</h6>
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <p class="text-center text-muted">No billing history found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Reference / Invoice #</th>
                                <th>Date</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>
                                    {{ $payment->invoice_number ?? $payment->transaction_reference }}
                                </td>
                                <td>
                                    {{ $payment->invoice_date ? $payment->invoice_date->format('M d, Y') : $payment->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    {{ $payment->plan->name }} ({{ ucfirst($payment->plan->billing_cycle) }})
                                </td>
                                <td>
                                    Rs. {{ number_format($payment->amount, 2) }}
                                </td>
                                <td>
                                    @if($payment->status === 'approved')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
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
                <div class="mt-3">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


