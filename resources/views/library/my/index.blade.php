﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">My Library</h2>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Book</th>
                                <th>Issued</th>
                                <th>Due</th>
                                <th>Returned</th>
                                <th class="text-end">Fine</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <td class="fw-bold">{{ optional($loan->book)->title }}</td>
                                    <td>{{ $loan->issued_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                                    <td>{{ $loan->returned_at ? $loan->returned_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td class="text-end">
                                        @if($loan->status==='issued')
                                            {{ number_format($loan->currentAccruedFine(), 2) }}
                                        @else
                                            {{ number_format($loan->fine_amount, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $loan->status === 'returned' ? 'bg-success' : ($loan->status === 'overdue' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



