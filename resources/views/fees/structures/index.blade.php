<x-app-layout>
    <x-slot name="header">
        {{ __('Fee Structures') }}
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title h5 mb-0">Manage Fee Structures</h3>
                    <a href="{{ route('fee-structures.create') }}" class="btn btn-primary">
                        Add New Fee Structure
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Class</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Frequency</th>
                                <th>Academic Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeStructures as $structure)
                                <tr>
                                    <td>{{ $structure->schoolClass->name }}</td>
                                    <td>{{ $structure->feeType->name }}</td>
                                    <td>{{ $structure->amount }}</td>
                                    <td>
                                        @if($structure->frequency == 1) Monthly
                                        @elseif($structure->frequency == 2) Quarterly
                                        @elseif($structure->frequency == 3) Annually
                                        @else One-time
                                        @endif
                                    </td>
                                    <td>{{ $structure->academic_year }}</td>
                                    <td>
                                        <a href="{{ route('fee-structures.edit', $structure->id) }}" class="btn btn-sm btn-info text-white me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('fee-structures.destroy', $structure->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
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
