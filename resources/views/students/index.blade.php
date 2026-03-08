<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold h4 text-dark lh-sm">
                {{ __('Students') }}
            </h2>
            <a href="{{ route('students.create') }}" class="btn btn-primary text-uppercase fw-semibold small">
                {{ __('Add New Student') }}
            </a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container px-4">
            <div class="card shadow-sm">
                <div class="card-body text-dark">
                    <div class="table-responsive">
                        <table class="table table-hover w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Admission No</th>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Parent</th>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th scope="col" class="px-3 py-3 text-start small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-body">
                                @forelse($students as $student)
                                <tr>
                                    <td class="px-3 py-4 text-nowrap small text-dark">
                                        {{ $student->admission_number }}
                                    </td>
                                    <td class="px-3 py-4 text-nowrap small fw-medium text-dark">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </td>
                                    <td class="px-3 py-4 text-nowrap small text-secondary">
                                        {{ $student->schoolClass->name }}
                                    </td>
                                    <td class="px-3 py-4 text-nowrap small text-secondary">
                                        {{ $student->section->name }}
                                    </td>
                                    <td class="px-3 py-4 text-nowrap small text-secondary">
                                        @foreach($student->parents as $parent)
                                            <div>{{ $parent->name }} <span class="small text-secondary">({{ $parent->pivot->relation }})</span></div>
                                        @endforeach
                                    </td>
                                    <td class="px-3 py-4 text-nowrap">
                                        @php
                                            $statusClasses = match($student->status) {
                                                'active' => 'bg-success-subtle text-success',
                                                'graduated' => 'bg-primary-subtle text-primary',
                                                default => 'bg-danger-subtle text-danger',
                                            };
                                        @endphp
                                        <span class="d-inline-flex align-items-center px-2 py-1 rounded-pill small fw-medium {{ $statusClasses }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 text-nowrap small fw-medium">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('students.show', $student) }}" class="text-info">View</a>
                                            <a href="{{ route('students.edit', $student) }}" class="text-primary">Edit</a>
                                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger ms-2 btn btn-link p-0 text-decoration-none">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-nowrap small text-secondary text-center">
                                        No students found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




