﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Inventory Item') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('inventory.items.store') }}">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Name</label>
                                <input name="name" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">SKU</label>
                                <input name="sku" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Unit</label>
                                <input name="unit" class="form-control">
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Opening Stock</label>
                                <input type="number" name="opening_stock" min="0" value="0" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Reorder Level</label>
                                <input type="number" name="reorder_level" min="0" value="0" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                            <a href="{{ route('inventory.items.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






