﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Drivers') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="mb-4">
                <a href="{{ route('transport.drivers.create') }}" class="btn btn-primary">New Driver</a>
            </div>
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">License</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                    <tr>
                                        <td class="p-3 align-middle">{{ $driver->name }}</td>
                                        <td class="p-3 align-middle">{{ $driver->phone }}</td>
                                        <td class="p-3 align-middle">{{ $driver->license_number }}</td>
                                        <td class="p-3 align-middle">{{ ucfirst($driver->status) }}</td>
                                        <td class="p-3 align-middle text-end">
                                            <a href="{{ route('transport.drivers.edit', $driver) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('transport.drivers.destroy', $driver) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this driver?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






