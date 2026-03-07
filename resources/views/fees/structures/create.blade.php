<x-app-layout>
    <x-slot name="header">
        {{ __('Create Fee Structure') }}
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('fee-structures.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="school_class_id" class="form-label">Class:</label>
                            <select name="school_class_id" id="school_class_id" class="form-select" required>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fee_type_id" class="form-label">Fee Type:</label>
                            <select name="fee_type_id" id="fee_type_id" class="form-select" required>
                                @foreach($feeTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount:</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="frequency" class="form-label">Frequency:</label>
                            <select name="frequency" id="frequency" class="form-select" required>
                                <option value="1">Monthly</option>
                                <option value="2">Quarterly</option>
                                <option value="3">Annually</option>
                                <option value="0">One-time</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="academic_year" class="form-label">Academic Year:</label>
                            <input type="text" name="academic_year" id="academic_year" value="{{ date('Y') }}-{{ date('Y')+1 }}" class="form-control">
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

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-primary">
                            Create Fee Structure
                        </button>
                        <a href="{{ route('fee-structures.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
