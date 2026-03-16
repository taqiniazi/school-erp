<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Edit Supplier') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('inventory.suppliers.update', $supplier) }}">
                        @csrf
                        @method('PUT')
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Name</label>
                                <input name="name" value="{{ old('name', $supplier->name) }}" class="form-control" required>
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Contact Person</label>
                                <input name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" class="form-control">
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Phone</label>
                                <input name="phone" value="{{ old('phone', $supplier->phone) }}" class="form-control">
                            </div>
                            <div>
                                <label class="d-block text-dark small fw-bold mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="d-block text-dark small fw-bold mb-2">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $supplier->address) }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                            <a href="{{ route('inventory.suppliers.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

