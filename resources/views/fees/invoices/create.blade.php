﻿x-app-layout>
    <div class="container-fluid py-4">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('fee-invoices.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="school_class_id" class="form-label">Class:</label>
                            <select name="school_class_id" id="school_class_id" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="student_id" class="form-label">Student (Optional):</label>
                            <select name="student_id" id="student_id" class="form-select">
                                <option value="">All Students</option>
                            </select>
                            <div class="form-text">Leave blank to generate for all students in the selected class.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Fee Type:</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="monthly">Monthly Fees</option>
                                <option value="annual">Annual Fees</option>
                                <option value="one_time">One-time Fees</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="issue_date" class="form-label">Issue Date:</label>
                            <input type="date" name="issue_date" id="issue_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">Due Date:</label>
                            <input type="date" name="due_date" id="due_date" value="{{ date('Y-m-d', strtotime('+10 days')) }}" class="form-control" required>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('This will generate invoices for all active students in the selected class. Are you sure?')">
                            Generate Invoices
                        </button>
                        <a href="{{ route('fee-invoices.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('school_class_id').addEventListener('change', function() {
            var classId = this.value;
            var studentSelect = document.getElementById('student_id');
            
            // Clear current options
            studentSelect.innerHTML = '<option value="">All Students</option>';
            
            if (classId) {
                // Fetch students for the selected class
                fetch(`/classes/${classId}/students`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(student => {
                            var option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = `${student.first_name} ${student.last_name} (${student.admission_number})`;
                            studentSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching students:', error));
            }
        });
    </script>
    @endpush
</x-app-layout>


