<x-app-layout>
    <x-slot name="header">
        {{ __('Collect Payment') }}
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('fee-invoices.pay', $feeInvoice->id) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount to Pay (Max: {{ number_format($feeInvoice->balance, 2) }}):</label>
                            <input type="number" step="0.01" name="amount" id="amount" max="{{ $feeInvoice->balance }}" value="{{ $feeInvoice->balance }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_date" class="form-label">Payment Date:</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Payment Method:</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Online">Online</option>
                                <option value="Card">Card</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="transaction_reference" class="form-label">Transaction Reference (Optional):</label>
                            <input type="text" name="transaction_reference" id="transaction_reference" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="remarks" class="form-label">Remarks (Optional):</label>
                            <textarea name="remarks" id="remarks" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-success">
                            Process Payment
                        </button>
                        <a href="{{ route('fee-invoices.show', $feeInvoice->id) }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
