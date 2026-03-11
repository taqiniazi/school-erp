﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Returns') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <div></div>
                        <a href="{{ route('inventory.returns.create') }}" class="btn btn-primary">New Return</a>
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
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Ref</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($returns as $r)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $r->return_date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ $r->item->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $r->reference ?? '-' }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $r->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $returns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





