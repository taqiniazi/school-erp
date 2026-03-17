<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-white">Create Fee Structure</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('fee-structures.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="school_class_id" class="form-label">Class:</label>
                                    <select name="school_class_id" id="school_class_id" class="form-select @error('school_class_id') is-invalid @enderror" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ (string) old('school_class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('school_class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="fee_type_id" class="form-label">Fee Type:</label>
                                    <select name="fee_type_id" id="fee_type_id" class="form-select @error('fee_type_id') is-invalid @enderror" required>
                                        <option value="">Select Fee Type</option>
                                        @foreach($feeTypes as $type)
                                            <option value="{{ $type->id }}" {{ (string) old('fee_type_id') === (string) $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('fee_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Amount:</label>
                                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="frequency" class="form-label">Frequency:</label>
                                    <select name="frequency" id="frequency" class="form-select @error('frequency') is-invalid @enderror" required>
                                        <option value="">Select Frequency</option>
                                        <option value="1" {{ (string) old('frequency') === '1' ? 'selected' : '' }}>Monthly</option>
                                        <option value="2" {{ (string) old('frequency') === '2' ? 'selected' : '' }}>Quarterly</option>
                                        <option value="3" {{ (string) old('frequency') === '3' ? 'selected' : '' }}>Annually</option>
                                        <option value="0" {{ (string) old('frequency') === '0' ? 'selected' : '' }}>One-time</option>
                                    </select>
                                    @error('frequency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="academic_year" class="form-label">Academic Year:</label>
                                    <input type="text" name="academic_year" id="academic_year" value="{{ old('academic_year', date('Y').'-'.(date('Y') + 1)) }}" class="form-control @error('academic_year') is-invalid @enderror">
                                    @error('academic_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('fee-structures.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Create Fee Structure
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
