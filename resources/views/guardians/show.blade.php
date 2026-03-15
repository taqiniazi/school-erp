<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-0">{{ $guardian->name }}</h1>
                <div class="text-muted">Guardian details and linked students.</div>
            </div>
            <a href="{{ route('guardians.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="fw-semibold mb-2">Contact</div>
                        <div class="mb-1"><span class="text-muted">Email:</span> {{ $guardian->email }}</div>
                        <div><span class="text-muted">Phone:</span> {{ $guardian->phone_number }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-semibold">Linked Students</div>
                            <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-2">
                                {{ $guardian->students->count() }} total
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover w-100 mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Admission No</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Relation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($guardian->students as $student)
                                        <tr>
                                            <td class="p-3 text-nowrap">{{ $student->admission_number }}</td>
                                            <td class="p-3 text-nowrap fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="p-3 text-nowrap">{{ $student->schoolClass->name ?? '' }}</td>
                                            <td class="p-3 text-nowrap">{{ $student->section->name ?? '' }}</td>
                                            <td class="p-3 text-nowrap">{{ $student->pivot->relation ?? 'Guardian' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-3 text-center text-secondary">No students linked.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

