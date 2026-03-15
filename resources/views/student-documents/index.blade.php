<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">Student Documents</h1>
                <div class="text-muted">Upload and manage documents per student.</div>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('student-documents.index') }}" class="row g-3 align-items-end">
                    <div class="col-12 col-md-8">
                        <label class="form-label">Student</label>
                        <select name="student_id" class="form-select">
                            <option value="">All Students</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ (string) $studentId === (string) $s->id ? 'selected' : '' }}>
                                    {{ $s->admission_number }} - {{ $s->first_name }} {{ $s->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 d-flex gap-2 justify-content-md-end">
                        <button type="submit" class="btn btn-outline-secondary">Filter</button>
                        <a href="{{ route('student-documents.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('student-documents.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-12 col-md-5">
                        <label class="form-label">Student</label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Select Student</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ (string) old('student_id', $studentId) === (string) $s->id ? 'selected' : '' }}>
                                    {{ $s->admission_number }} - {{ $s->first_name }} {{ $s->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Title (optional)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Birth Certificate">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Title</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">File</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                                <tr>
                                    <td class="p-3 text-nowrap">
                                        {{ $doc->student->admission_number ?? '' }} - {{ $doc->student->first_name ?? '' }} {{ $doc->student->last_name ?? '' }}
                                    </td>
                                    <td class="p-3 text-nowrap">{{ $doc->title }}</td>
                                    <td class="p-3 text-nowrap">{{ $doc->file_name }}</td>
                                    <td class="p-3 text-nowrap text-end">
                                        <a href="{{ route('student-documents.download', $doc) }}" class="btn btn-sm btn-outline-primary">Download</a>
                                        <form action="{{ route('student-documents.destroy', $doc) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this document?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-secondary">No documents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
