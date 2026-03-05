<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Drivers') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('transport.drivers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">New Driver</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">License</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($drivers as $driver)
                                    <tr>
                                        <td class="px-6 py-4">{{ $driver->name }}</td>
                                        <td class="px-6 py-4">{{ $driver->phone }}</td>
                                        <td class="px-6 py-4">{{ $driver->license_number }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($driver->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('transport.drivers.edit', $driver) }}" class="text-blue-600">Edit</a>
                                            <form action="{{ route('transport.drivers.destroy', $driver) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 ml-3" onclick="return confirm('Delete this driver?')">Delete</button>
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

