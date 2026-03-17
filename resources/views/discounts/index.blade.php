<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">
            Discounts
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="mb-3">
                                {{ $editingDiscount ? 'Edit Discount' : 'Add Discount' }}
                            </h5>

                            <form method="POST" action="{{ $editingDiscount ? route('discounts.update', $editingDiscount) : route('discounts.store') }}">
                                @csrf
                                @if ($editingDiscount)
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $editingDiscount?->name) }}"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <select name="type" class="form-select" required>
                                        @php($selectedType = old('type', $editingDiscount?->type ?? 'fixed'))
                                        <option value="fixed" {{ $selectedType === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ $selectedType === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Value</label>
                                    <input
                                        type="number"
                                        name="value"
                                        step="0.01"
                                        min="0"
                                        class="form-control"
                                        value="{{ old('value', $editingDiscount?->value ?? 0) }}"
                                        required
                                    >
                                    <div class="form-text">For percentage, enter 10 for 10%.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $editingDiscount?->description) }}</textarea>
                                </div>

                                @php($active = old('is_active', $editingDiscount ? (int) $editingDiscount->is_active : 1))
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ (int) $active === 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $editingDiscount ? 'Save' : 'Create' }}
                                    </button>
                                    @if ($editingDiscount)
                                        <a href="{{ route('discounts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="mb-3">All Discounts</h5>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th class="text-end">Value</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($discounts as $discount)
                                            <tr>
                                                <td class="text-nowrap">{{ $discount->name }}</td>
                                                <td class="text-nowrap">{{ ucfirst($discount->type) }}</td>
                                                <td class="text-end text-nowrap">
                                                    @if ($discount->type === 'percentage')
                                                        {{ rtrim(rtrim(number_format((float) $discount->value, 2), '0'), '.') }}%
                                                    @else
                                                        {{ number_format((float) $discount->value, 2) }}
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    <span class="badge {{ $discount->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $discount->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="text-end text-nowrap">
                                                    <a href="{{ route('discounts.edit', $discount) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                    <form method="POST" action="{{ route('discounts.destroy', $discount) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this discount?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-secondary py-4">No discounts found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
