<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">Library Reports</h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="small text-secondary">Total Books</div>
                        <div class="h4 fw-bold mb-0">{{ number_format($totalBooks) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="small text-secondary">Active Books</div>
                        <div class="h4 fw-bold mb-0">{{ number_format($activeBooks) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="small text-secondary">Issued Loans</div>
                        <div class="h4 fw-bold mb-0">{{ number_format($issuedLoansCount) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="small text-secondary">Overdue</div>
                        <div class="h4 fw-bold mb-0">{{ number_format($overdueCount) }}</div>
                        <div class="small text-secondary mt-1">Accrued Fine: {{ number_format($overdueAccruedFine, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-0 py-3">
                <div class="fw-semibold">Overdue Loans</div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Book</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Borrower</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Due Date</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Days</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Accrued Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($overdueLoans as $loan)
                                <tr>
                                    <td class="p-3 fw-semibold">{{ optional($loan->book)->title }}</td>
                                    <td class="p-3 text-nowrap">{{ optional($loan->user)->name }}</td>
                                    <td class="p-3 text-nowrap">{{ optional($loan->due_date)->format('Y-m-d') }}</td>
                                    <td class="p-3 text-end text-nowrap">{{ $loan->currentOverdueDays() }}</td>
                                    <td class="p-3 text-end text-nowrap">{{ number_format($loan->currentAccruedFine(), 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center text-secondary">No overdue loans.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
