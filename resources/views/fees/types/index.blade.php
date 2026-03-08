<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">Fee Types</h2>
            <a href="{{ route('fee-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Fee Type
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeTypes as $type)
                                <tr>
                                    <td>{{ $type->id }}</td>
                                    <td class="fw-bold">{{ $type->name }}</td>
                                    <td>{{ $type->description }}</td>
                                    <td>
                                        <a href="{{ route('fee-types.edit', $type->id) }}" class="btn btn-sm btn-primary me-2">Edit</a>
                                        <form action="{{ route('fee-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


