<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Vehicle') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('transport.vehicles.update', $vehicle) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Registration Number</label>
                            <input type="text" name="registration_number" value="{{ $vehicle->registration_number }}" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Model</label>
                            <input type="text" name="model" value="{{ $vehicle->model }}" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" min="0" name="capacity" value="{{ $vehicle->capacity }}" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Driver</label>
                            <select name="driver_id" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="">None</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" @if($vehicle->driver_id==$driver->id) selected @endif>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Route</label>
                            <select name="transport_route_id" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="">None</option>
                                @foreach($routes as $route)
                                    <option value="{{ $route->id }}" @if($vehicle->transport_route_id==$route->id) selected @endif>{{ $route->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="active" @if($vehicle->status==='active') selected @endif>Active</option>
                                <option value="inactive" @if($vehicle->status==='inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                            <a href="{{ route('transport.vehicles.index') }}" class="ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

