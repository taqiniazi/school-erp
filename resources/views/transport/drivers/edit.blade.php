<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Driver') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('transport.drivers.update', $driver) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" value="{{ $driver->name }}" class="mt-1 block w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ $driver->phone }}" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">License Number</label>
                            <input type="text" name="license_number" value="{{ $driver->license_number }}" class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="active" @if($driver->status==='active') selected @endif>Active</option>
                                <option value="inactive" @if($driver->status==='inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                            <a href="{{ route('transport.drivers.index') }}" class="ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

