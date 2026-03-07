<x-app-layout>
    <x-slot name="header">
        {{ __('Fee Invoices') }}
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title h5 mb-0">Manage Invoices</h3>
                    @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin'))
                        <a href="{{ route('fee-invoices.create') }}" class="btn btn-primary">
                            Generate Invoices (Bulk)
                        </a>
                    @endif
                </div>

                <!-- Filter Form -->
                <form action="{{ route('fee-invoices.index') }}" method="GET" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Class</label>
                            <select name="class_id" class="form-select">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Student ID</label>
                            <input type="text" name="student_id" placeholder="Student ID (Optional)" value="{{ request('student_id') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark w-100">Filter</button>
                        </div>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice No</th>
                                <th>Student</th>
                                <th>Class</th>
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
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->student->first_name }} {{ $invoice->student->last_name }}</td>
                                    <td>{{ $invoice->student->schoolClass->name }}</td>
                                    <td>{{ $invoice->issue_date }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td>{{ number_format($invoice->total_amount + $invoice->fine_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->paid_amount + $invoice->discount_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->balance, 2) }}</td>
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
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($invoice->balance > 0)
                                            <a href="{{ route('fee-invoices.collect', $invoice->id) }}" class="btn btn-sm btn-success text-white">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
