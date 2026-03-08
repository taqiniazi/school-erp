<x-app-layout>
    <x-slot name="header">
        {{ __('My Invoices') }}
    </x-slot>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                Invoices for {{ $student->first_name }} {{ $student->last_name }}
            </h6>
        </div>
        <div class="card-body">
            @if(isset($children) && $children->count() > 0)
                <form method="GET" action="{{ route('student.invoices') }}" class="mb-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="student_id" class="col-form-label fw-bold">Select Child:</label>
                        </div>
                        <div class="col-auto">
                            <select name="student_id" id="student_id" class="form-select" onchange="this.form.submit()">
                                @foreach($children as $child)
                                    <option value="{{ $child->id }}" {{ isset($student) && $student->id == $child->id ? 'selected' : '' }}>
                                        {{ $child->first_name }} {{ $child->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice #</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="fw-bold">{{ $invoice->invoice_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                                <td>{{ number_format($invoice->total_amount + $invoice->fine_amount, 2) }}</td>
                                <td class="text-success">{{ number_format($invoice->paid_amount + $invoice->discount_amount, 2) }}</td>
                                <td class="text-danger fw-bold">
                                    {{ number_format(($invoice->total_amount + $invoice->fine_amount) - ($invoice->paid_amount + $invoice->discount_amount), 2) }}
                                </td>
                                <td>
                                    @if($invoice->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($invoice->status === 'partial')
                                        <span class="badge bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->status !== 'paid')
                                        <a href="#" class="btn btn-sm btn-primary">Pay Now</a>
                                    @else
                                        <span class="text-muted small">Paid</span>
                                    @endif
                                    <a href="{{ route('fee-invoices.show', $invoice->id) }}" class="btn btn-sm btn-info text-white">View</a>
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
</x-app-layout>
