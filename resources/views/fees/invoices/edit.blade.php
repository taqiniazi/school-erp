<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">{{ __('Edit Invoice') }} #{{ $feeInvoice->invoice_no }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('fee-invoices.update', $feeInvoice) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Student Name:</label>
                            <p class="form-control-plaintext">{{ $feeInvoice->student->first_name }} {{ $feeInvoice->student->last_name }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="issue_date" class="form-label fw-bold">Issue Date:</label>
                            <input type="date" name="issue_date" id="issue_date" value="{{ $feeInvoice->issue_date }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="due_date" class="form-label fw-bold">Due Date:</label>
                            <input type="date" name="due_date" id="due_date" value="{{ $feeInvoice->due_date }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="fine_amount" class="form-label fw-bold">Fine Amount:</label>
                            <input type="number" step="0.01" name="fine_amount" id="fine_amount" value="{{ $feeInvoice->fine_amount }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="discount_amount" class="form-label fw-bold">Discount Amount:</label>
                            <input type="number" step="0.01" name="discount_amount" id="discount_amount" value="{{ $feeInvoice->discount_amount }}" class="form-control">
                        </div>
                        
                         <div class="col-12">
                            <label for="remarks" class="form-label fw-bold">Remarks:</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ $feeInvoice->remarks }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-primary">
                            Update Invoice
                        </button>
                        <a href="{{ route('fee-invoices.show', $feeInvoice) }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


