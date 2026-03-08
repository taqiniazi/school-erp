@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Marks Entry
    </div>
    <div class="card-body">
        <form action="{{ route('marks.create') }}" method="GET" class="row g-3">
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
                <label for="subject_id" class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">Select Subject</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Proceed to Marks Entry</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('school_class_id').addEventListener('change', function() {
        var classId = this.value;
        var sectionSelect = document.getElementById('section_id');
        var subjectSelect = document.getElementById('subject_id');
        
        sectionSelect.innerHTML = '<option value="">Loading...</option>';
        subjectSelect.innerHTML = '<option value="">Loading...</option>';

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

            // Load Subjects
            fetch(`/classes/${classId}/subjects`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    data.forEach(subject => {
                        subjectSelect.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                    });
                });
        } else {
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
        }
    });
</script>
@endsection
