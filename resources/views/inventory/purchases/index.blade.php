﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Purchases') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <div></div>
                        <a href="{{ route('inventory.purchases.create') }}" class="btn btn-primary">New Purchase</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Item</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Qty</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Unit Cost</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Vendor</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Ref</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $p)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $p->purchase_date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ $p->item->name }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $p->quantity }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ number_format($p->unit_cost, 2) }}</td>
                                        <td class="p-3 text-nowrap">{{ $p->vendor ?? '-' }}</td>
                                        <td class="p-3 text-nowrap">{{ $p->reference_no ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





