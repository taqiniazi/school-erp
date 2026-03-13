<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Search Student Report Card</h1>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('marks.generate_report_card') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="exam_id" class="form-label">Exam</label>
                        <select name="exam_id" id="exam_id" class="form-select" required>
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="school_class_id" class="form-label">Class</label>
                        <select name="school_class_id" id="school_class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select name="section_id" id="section_id" class="form-select" required>
                            <option value="">Select Section</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="student_id" class="form-label">Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">Select Student</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Generate Report Card</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.getElementById('school_class_id').addEventListener('change', function() {
        var classId = this.value;
        var sectionSelect = document.getElementById('section_id');
        var studentSelect = document.getElementById('student_id');
        
        sectionSelect.innerHTML = '<option value="">Loading...</option>';
        studentSelect.innerHTML = '<option value="">Select Section First</option>';

        if (classId) {
            // Load Sections
            fetch(`/classes/${classId}/sections`)
                .then(response => response.json())
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    data.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                    });
                });
        } else {
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
        }
    });

    document.getElementById('section_id').addEventListener('change', function() {
        var sectionId = this.value;
        var studentSelect = document.getElementById('student_id');
        
        studentSelect.innerHTML = '<option value="">Loading...</option>';

        if (sectionId) {
            // Load Students (Assuming route exists or creating one?)
            // I don't have a route to get students by section yet?
            // Wait, I can use `students.index` maybe? Or create a helper.
            // Let's create a helper route in web.php or use existing if any.
            // I don't see one. I'll add one.
            fetch(`/sections/${sectionId}/students`)
                .then(response => response.json())
                .then(data => {
                    studentSelect.innerHTML = '<option value="">Select Student</option>';
                    data.forEach(student => {
                        studentSelect.innerHTML += `<option value="${student.id}">${student.first_name} ${student.last_name} (${student.roll_number})</option>`;
                    });
                });
        } else {
            studentSelect.innerHTML = '<option value="">Select Student</option>';
        }
    });
</script>
</x-app-layout>
