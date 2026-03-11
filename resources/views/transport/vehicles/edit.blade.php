﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Edit Vehicle') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('transport.vehicles.update', $vehicle) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Registration Number</label>
                            <input type="text" name="registration_number" value="{{ $vehicle->registration_number }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" value="{{ $vehicle->model }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Capacity</label>
                            <input type="number" min="0" name="capacity" value="{{ $vehicle->capacity }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Driver</label>
                            <select name="driver_id" class="form-select">
                                <option value="">None</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" @if($vehicle->driver_id==$driver->id) selected @endif>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Route</label>
                            <select name="transport_route_id" class="form-select">
                                <option value="">None</option>
                                @foreach($routes as $route)
                                    <option value="{{ $route->id }}" @if($vehicle->transport_route_id==$route->id) selected @endif>{{ $route->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" @if($vehicle->status==='active') selected @endif>Active</option>
                                <option value="inactive" @if($vehicle->status==='inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('transport.vehicles.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





