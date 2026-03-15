<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">{{ __('Fee Payments Report') }}</h6>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form method="GET" action="{{ route('fee-payments.index') }}" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>
                        <!-- Could add student search here, but for now simple date range is good -->
                        <div class="col-md-3 d-flex g-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('fee-payments.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="alert alert-success mb-4">
                    <strong>Total Collected:</strong> {{ number_format($totalCollected, 2) }}
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Collected By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_date }}</td>
                                    <td>
                                        {{ $payment->invoice->student->first_name }} {{ $payment->invoice->student->last_name }}
                                    </td>
                                    <td>{{ $payment->invoice->student->schoolClass->name }}</td>
                                    <td>
                                        <a href="{{ route('fee-invoices.show', $payment->fee_invoice_id) }}" class="text-decoration-none">
                                            {{ $payment->invoice->invoice_no }}
                                        </a>
                                    </td>
                                    <td class="fw-bold text-success">{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ $payment->collectedBy->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
