<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Purchase') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('inventory.purchases.store') }}">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Item</label>
                                <select name="inventory_item_id" class="form-select" required>
                                    @foreach($items as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }} ({{ $i->sku }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Quantity</label>
                                <input type="number" name="quantity" min="1" value="1" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Unit Cost</label>
                                <input type="number" step="0.01" min="0" name="unit_cost" value="0" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Vendor</label>
                                <input name="vendor" class="form-control">
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Reference No</label>
                                <input name="reference_no" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                            <a href="{{ route('inventory.purchases.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






