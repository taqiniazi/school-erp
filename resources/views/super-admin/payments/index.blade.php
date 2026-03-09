@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold">Payment Verification</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>School / User</th>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Proof</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $payment->school->name ?? 'N/A' }}</div>
                                            <small class="text-muted">ID: {{ $payment->school_id }}</small>
                                        </td>
                                        <td>{{ $payment->plan->name ?? 'N/A' }}</td>
                                        <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            @if($payment->paymentMethod)
                                                <span class="badge bg-info text-dark">{{ $payment->paymentMethod->name }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($payment->payment_method) }}</span>
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $payment->transaction_reference }}</small>
                                        </td>
                                        <td>
                                            @if($payment->proof_file_path)
                                                <a href="{{ asset('storage/' . $payment->proof_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->status === 'pending')
                                                <form action="{{ route('super-admin.payments.update', $payment->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <textarea name="admin_note" rows="2" class="form-control mb-2" placeholder="Admin Note (Optional)"></textarea>
                                                    
                                                    <div class="d-flex gap-2">
                                                        <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
                                                        <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                                                    </div>
                                                </form>
                                            @else
                                                <small class="text-muted">{{ $payment->admin_note ?? 'No notes' }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



