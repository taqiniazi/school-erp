<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Edit Exam</h1>
            <a href="{{ route('exams.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('exams.update', $exam) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Exam Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $exam->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="session_year" class="form-label">Session Year</label>
                        <input type="text" name="session_year" class="form-control" id="session_year" value="{{ $exam->session_year }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $exam->start_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $exam->end_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description">{{ $exam->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Exam</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
