﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Issue') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('inventory.issues.store') }}">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Item</label>
                                <select name="inventory_item_id" class="form-select" required>
                                    @foreach($items as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }} (Stock: {{ $i->current_stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Quantity</label>
                                <input type="number" name="quantity" min="1" value="1" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Issue Date</label>
                                <input type="date" name="issue_date" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Recipient</label>
                                <input name="recipient" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Remarks</label>
                                <textarea name="remarks" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                            <a href="{{ route('inventory.issues.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






