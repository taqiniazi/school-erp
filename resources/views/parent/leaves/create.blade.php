<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">New Student Leave Request</h1>
            <a href="{{ route('parent.leaves.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                @if(!empty($tableMissing) && $tableMissing)
                    <div class="alert alert-warning mb-4" role="alert">
                        Student leave requests are not available yet because the database table/schema is missing. Run <code>php artisan migrate</code>.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <div class="fw-semibold mb-2">Please fix the following:</div>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('parent.leaves.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        <div class="col-12">
                            <label class="form-label">Child</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">Select Child</option>
                                @foreach($children as $child)
                                    <option value="{{ $child->id }}" {{ (string) old('student_id', $selectedStudentId) === (string) $child->id ? 'selected' : '' }}>
                                        {{ $child->first_name }} {{ $child->last_name }} ({{ $child->roll_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                        </div>
                        <div>
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Reason</label>
                            <textarea name="reason" class="form-control" rows="3" required>{{ old('reason') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Attachment (Optional)</label>
                            <input type="file" name="attachment" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                            <div class="form-text">Max 5MB. PDF/JPG/PNG.</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <button class="btn btn-primary px-4" @if(!empty($tableMissing) && $tableMissing) disabled @endif>Submit</button>
                        <a href="{{ route('parent.leaves.index') }}" class="btn btn-link text-decoration-none text-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
