<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Income') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <form method="GET" class="flex items-end space-x-2">
                            <div>
                                <label class="block text-sm text-gray-700">Year</label>
                                <select name="financial_year_id" class="border rounded px-2 py-1">
                                    <option value="">All</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y->id }}" {{ request('financial_year_id') == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">From</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-2 py-1">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">To</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-2 py-1">
                            </div>
                            <button class="px-3 py-2 bg-gray-200 rounded">Filter</button>
                        </form>
                        <a href="{{ route('accounting.income.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            New Income
                        </a>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($incomes as $row)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->financialYear->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-green-600">{{ number_format($row->amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('accounting.income.edit', $row) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                            <form action="{{ route('accounting.income.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('Delete this income?')">
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
                    <div class="mt-4">
                        {{ $incomes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

