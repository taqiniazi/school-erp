﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Low Stock Alerts') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">SKU</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Stock</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Reorder Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr class="table-danger">
                                        <td class="p-3 text-nowrap">{{ $item->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $item->sku }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $item->current_stock }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $item->reorder_level }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-3">No low stock items</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






