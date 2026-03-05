<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profit & Loss') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" class="mb-6">
                        <label class="text-sm text-gray-700 mr-2">Financial Year</label>
                        <select name="financial_year_id" class="border rounded px-2 py-1">
                            <option value="">Select</option>
                            @foreach($years as $y)
                                <option value="{{ $y->id }}" {{ optional($selectedYear)->id == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>
                            @endforeach
                        </select>
                        <button class="ml-2 px-3 py-2 bg-gray-200 rounded">Apply</button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="p-4 bg-green-50 border rounded">
                            <div class="text-sm text-gray-500">Total Income</div>
                            <div class="text-2xl font-bold text-green-700">{{ number_format($totalIncome, 2) }}</div>
                        </div>
                        <div class="p-4 bg-red-50 border rounded">
                            <div class="text-sm text-gray-500">Total Expenses</div>
                            <div class="text-2xl font-bold text-red-700">{{ number_format($totalExpense, 2) }}</div>
                        </div>
                        <div class="p-4 bg-blue-50 border rounded">
                            <div class="text-sm text-gray-500">Net</div>
                            <div class="text-2xl font-bold {{ $net >= 0 ? 'text-green-700' : 'text-red-700' }}">{{ number_format($net, 2) }}</div>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium mb-2">Monthly Breakdown</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Income</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Net</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($monthly as $m)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $m->ym }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-green-700">{{ number_format($m->income, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-red-700">{{ number_format($m->expense, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold {{ $m->net >= 0 ? 'text-green-700' : 'text-red-700' }}">{{ number_format($m->net, 2) }}</td>
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

