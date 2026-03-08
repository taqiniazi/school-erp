<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">{{ __('Invoice Details') }} - {{ $feeInvoice->invoice_no }}</h6>
                <div>
                     <a href="{{ route('fee-invoices.print', $feeInvoice->id) }}" class="btn btn-secondary btn-sm me-2">
                        <i class="fas fa-file-pdf me-1"></i> Download PDF
                    </a>
                    @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin'))
                        <a href="{{ route('fee-invoices.edit', $feeInvoice->id) }}" class="btn btn-warning btn-sm text-white me-2">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    @endif
                    @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin') || Auth::user()->hasRole('Teacher'))
                        @if($feeInvoice->balance > 0)
                            <a href="{{ route('fee-invoices.collect', $feeInvoice->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-money-bill-wave me-1"></i> Collect Payment
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Student Details:</h5>
                        <p class="mb-1"><strong>Name:</strong> {{ $feeInvoice->student->first_name }} {{ $feeInvoice->student->last_name }}</p>
                        <p class="mb-1"><strong>Class:</strong> {{ $feeInvoice->student->schoolClass->name }}</p>
                        <p class="mb-1"><strong>Admission No:</strong> {{ $feeInvoice->student->admission_number }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5 class="fw-bold">Invoice Details:</h5>
                        <p class="mb-1"><strong>Issue Date:</strong> {{ $feeInvoice->issue_date }}</p>
                        <p class="mb-1"><strong>Due Date:</strong> {{ $feeInvoice->due_date }}</p>
                        <p class="mb-1"><strong>Status:</strong> 
                            <span class="badge {{ $feeInvoice->status == 'paid' ? 'bg-success' : ($feeInvoice->status == 'partial' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($feeInvoice->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Fee Items:</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeInvoice->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <!-- Summary -->
                            <tr class="fw-bold">
                                <td class="text-end">Subtotal</td>
                                <td class="text-end">{{ number_format($feeInvoice->total_amount, 2) }}</td>
                            </tr>
                            @if($feeInvoice->fine_amount > 0)
                                <tr>
                                    <td class="text-end text-danger">Fine</td>
                                    <td class="text-end text-danger">{{ number_format($feeInvoice->fine_amount, 2) }}</td>
                                </tr>
                            @endif
                            @if($feeInvoice->discount_amount > 0)
                                <tr>
                                    <td class="text-end text-success">Discount</td>
                                    <td class="text-end text-success">-{{ number_format($feeInvoice->discount_amount, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="fw-bold fs-5 table-secondary">
                                <td class="text-end">Total Payable</td>
                                <td class="text-end">{{ number_format($feeInvoice->total_amount + $feeInvoice->fine_amount - $feeInvoice->discount_amount, 2) }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td class="text-end">Paid Amount</td>
                                <td class="text-end text-success">{{ number_format($feeInvoice->paid_amount, 2) }}</td>
                            </tr>
                            <tr class="fw-bold fs-5 table-light">
                                <td class="text-end">Balance Due</td>
                                <td class="text-end text-danger">{{ number_format($feeInvoice->balance, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="fw-bold mb-3">Payment History:</h5>
                @if($feeInvoice->payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Collected By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feeInvoice->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date }}</td>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->transaction_reference }}</td>
                                        <td>{{ $payment->collectedBy->name ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted fst-italic">No payments recorded yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
