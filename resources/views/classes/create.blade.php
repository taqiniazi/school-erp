<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Create Class</h1>
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Numeric Value</label>
                        <input type="number" name="numeric_value" class="form-control" value="{{ old('numeric_value') }}" required>
                        @error('numeric_value') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Class Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Save Class</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

