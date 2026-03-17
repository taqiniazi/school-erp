﻿x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">My Library</h1>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Book</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Issued</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Due</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Returned</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Fine</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
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
            </div>
        </div>
    </div>
</x-app-layout>

