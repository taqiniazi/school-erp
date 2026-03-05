<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Financial Years') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium">Manage Financial Years</h3>
                        <a href="{{ route('financial-years.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            New Financial Year
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($years as $year)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $year->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $year->start_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $year->end_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($year->is_current)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Current</span>
                                            @else
                                                <form action="{{ route('financial-years.set-current', $year) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="px-2 py-1 text-xs bg-gray-200 rounded hover:bg-gray-300">Set Current</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('financial-years.edit', $year) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                            <form action="{{ route('financial-years.destroy', $year) }}" method="POST" class="inline" onsubmit="return confirm('Delete this financial year?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-800">Delete</button>
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
    </div>
</x-app-layout>

