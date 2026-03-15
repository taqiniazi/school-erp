<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Payment Verification</h1>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle" id="dataTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">School / User</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Plan</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Amount</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Method</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Proof</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="p-3">
                                            <div class="fw-bold">{{ $payment->school->name ?? 'N/A' }}</div>
                                            <small class="text-muted">ID: {{ $payment->school_id }}</small>
                                        </td>
                                        <td class="p-3 text-nowrap">{{ $payment->plan->name ?? 'N/A' }}</td>
                                        <td class="p-3 text-nowrap">Rs. {{ number_format($payment->amount, 2) }}</td>
                                        <td class="p-3">
                                            @if($payment->paymentMethod)
                                                <span class="badge bg-info text-dark">{{ $payment->paymentMethod->name }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($payment->payment_method) }}</span>
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $payment->transaction_reference }}</small>
                                        </td>
                                        <td class="p-3 text-nowrap">
                                            @if($payment->proof_file_path)
                                                <a href="{{ asset('storage/' . $payment->proof_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap">
                                            @if($payment->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td class="p-3">
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
                                        <td colspan="8" class="p-3 text-center text-secondary">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>

