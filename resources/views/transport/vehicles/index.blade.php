<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Vehicles') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="mb-4">
                <a href="{{ route('transport.vehicles.create') }}" class="btn btn-primary">New Vehicle</a>
            </div>
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Registration</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Model</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Capacity</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Driver</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Route</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td class="p-3 align-middle">{{ $vehicle->registration_number }}</td>
                                        <td class="p-3 align-middle">{{ $vehicle->model }}</td>
                                        <td class="p-3 align-middle text-end">{{ $vehicle->capacity }}</td>
                                        <td class="p-3 align-middle">{{ optional($vehicle->driver)->name }}</td>
                                        <td class="p-3 align-middle">{{ optional($vehicle->route)->name }}</td>
                                        <td class="p-3 align-middle">{{ ucfirst($vehicle->status) }}</td>
                                        <td class="p-3 align-middle text-end">
                                            <a href="{{ route('transport.vehicles.edit', $vehicle) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('transport.vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this vehicle?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $vehicles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






