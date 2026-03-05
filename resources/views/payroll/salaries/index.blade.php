<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Salaries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium">Active Salary Structures</h3>
                        <a href="{{ route('payroll.salaries.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">New</a>
                    </div>
                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Basic Salary</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Effective</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($salaries as $s)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $s->teacher->first_name }} {{ $s->teacher->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($s->basic_salary, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $s->effective_from }} @if($s->effective_to) - {{ $s->effective_to }} @endif</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('payroll.salaries.edit', $s) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                            <form action="{{ route('payroll.salaries.destroy', $s) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?')">
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

