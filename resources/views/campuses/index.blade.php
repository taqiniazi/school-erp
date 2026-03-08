<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            Manage Campuses
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h3 class="lead fw-medium text-dark">Campuses List</h3>
                        <a href="{{ route('campuses.create') }}" class="btn btn-primary">Add New Campus</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th scope="col" class="p-3 text-start small fw-medium text-secondary text-uppercase">Address</th>
                                    <th scope="col" class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                                    <th scope="col" class="p-3 text-start small fw-medium text-secondary text-uppercase">Is Main</th>
                                    <th scope="col" class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th scope="col" class="p-3 text-start small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($campuses as $campus)
                                    <tr>
                                        <td class="p-3 text-nowrap small fw-medium text-dark">{{ $campus->name }}</td>
                                        <td class="p-3 text-nowrap small text-secondary">{{ $campus->address ?? '—' }}</td>
                                        <td class="p-3 text-nowrap small text-secondary">{{ $campus->phone ?? '—' }}</td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            @if($campus->is_main)
                                                <span class="badge rounded-pill text-bg-primary">Yes</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-light">No</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            @if($campus->is_active)
                                                <span class="badge rounded-pill text-bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap small fw-medium">
                                            <a href="{{ route('campuses.edit', $campus) }}" class="btn btn-sm btn-link text-decoration-none">Edit</a>
                                            <form action="{{ route('campuses.destroy', $campus) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this campus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-3 text-nowrap small text-secondary text-center">No campuses found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $campuses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




