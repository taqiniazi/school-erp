﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('Issues') }}</h1>
            <a href="{{ route('inventory.issues.create') }}" class="btn btn-primary">New Issue</a>
        </div>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
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
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Recipient</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($issues as $i)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $i->issue_date->format('Y-m-d') }}</td>
                                        <td class="p-3 text-nowrap">{{ $i->item->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $i->recipient ?? '-' }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $i->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $issues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




