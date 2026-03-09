<x-app-layout>
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 text-gray-800 mb-1">Classes</h1>
                <p class="text-muted small mb-0">Manage academic classes, sections, and subject allocations.</p>
            </div>
            <a href="{{ route('classes.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i>Add New Class
            </a>
        </div>

        <!-- Main Content Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold"><i class="fas fa-chalkboard me-2"></i>Class List</h5>
                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search classes..." aria-label="Search">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Class Name</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Numeric Value</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Sections</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0">Subjects</th>
                                <th class="px-4 py-3 text-uppercase text-secondary small fw-bold border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $class)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="fw-bold text-dark">{{ $class->name }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border border-light-subtle rounded-pill px-3 py-2">
                                        Level {{ $class->numeric_value }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-2">
                                        {{ $class->sections->count() }} Sections
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-2">
                                        {{ $class->subjects->count() }} Subjects
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                            <li><a class="dropdown-item" href="{{ route('classes.show', $class) }}"><i class="fas fa-cogs text-info me-2"></i> Manage Sections</a></li>
                                            <li><a class="dropdown-item" href="{{ route('classes.edit', $class) }}"><i class="fas fa-edit text-warning me-2"></i> Edit Class</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-chalkboard fa-3x opacity-25"></i>
                                    </div>
                                    <h6 class="text-secondary fw-bold">No classes found</h6>
                                    <p class="text-muted small">Create classes to organize students and subjects.</p>
                                    <a href="{{ route('classes.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Add Class
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
