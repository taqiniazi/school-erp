<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Transport Assignments') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('transport.assignments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">New Assignment</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Route</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pickup</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($assignments as $a)
                                    <tr>
                                        <td class="px-6 py-4">
                                            {{ optional($a->student)->first_name }} {{ optional($a->student)->last_name }}
                                        </td>
                                        <td class="px-6 py-4">{{ optional($a->route)->name }}</td>
                                        <td class="px-6 py-4">{{ optional($a->vehicle)->registration_number }}</td>
                                        <td class="px-6 py-4">{{ $a->pickup_point }}</td>
                                        <td class="px-6 py-4">{{ optional($a->start_date)->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($a->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('transport.assignments.destroy', $a) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 ml-3" onclick="return confirm('Remove this assignment?')">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

