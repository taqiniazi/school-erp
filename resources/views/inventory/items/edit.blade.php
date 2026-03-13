﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Edit Inventory Item') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('inventory.items.update', $item) }}">
                        @csrf
                        @method('PUT')
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Name</label>
                                <input name="name" value="{{ $item->name }}" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">SKU</label>
                                <input name="sku" value="{{ $item->sku }}" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Unit</label>
                                <input name="unit" value="{{ $item->unit }}" class="form-control">
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Reorder Level</label>
                                <input type="number" name="reorder_level" min="0" value="{{ $item->reorder_level }}" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $item->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $item->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                            <a href="{{ route('inventory.items.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






