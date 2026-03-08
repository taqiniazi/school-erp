<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Inventory Items') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <div></div>
                        <a href="{{ route('inventory.items.create') }}" class="btn btn-primary">New Item</a>
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
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">SKU</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Unit</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Stock</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Reorder</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr class="{{ $item->current_stock <= $item->reorder_level ? 'table-danger' : '' }}">
                                        <td class="p-3 text-nowrap">{{ $item->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $item->sku }}</td>
                                        <td class="p-3 text-nowrap">{{ $item->unit ?? '-' }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $item->current_stock }}</td>
                                        <td class="p-3 text-nowrap text-end">{{ $item->reorder_level }}</td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('inventory.items.edit', $item) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('inventory.items.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete item?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





