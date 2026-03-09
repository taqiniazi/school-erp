<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">{{ __('My Invoices') }}</h6>
            </div>
            <div class="card-body">
                <h5 class="card-title mb-4">Fee History</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice No</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->issue_date }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td>
                                        {{ number_format($invoice->total_amount + $invoice->fine_amount - $invoice->discount_amount, 2) }}
                                        @if($invoice->fine_amount > 0) 
                                            <span class="d-block text-danger small">+{{ $invoice->fine_amount }} Fine</span> 
                                        @endif
                                        @if($invoice->discount_amount > 0) 
                                            <span class="d-block text-success small">-{{ $invoice->discount_amount }} Disc</span> 
                                        @endif
                                    </td>
                                    <td>{{ number_format($invoice->paid_amount, 2) }}</td>
                                    <td class="fw-bold">{{ number_format($invoice->balance, 2) }}</td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            @if($invoice->status == 'paid') bg-success 
                                            @elseif($invoice->status == 'partial') bg-warning text-dark
                                            @elseif($invoice->status == 'overdue') bg-danger
                                            @else bg-secondary @endif">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('fee-invoices.show', $invoice->id) }}" class="btn btn-sm btn-info text-white me-1">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('fee-invoices.print', $invoice->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No invoices found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


