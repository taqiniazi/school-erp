<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payslips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <form method="GET" class="flex items-end space-x-2">
                            <div>
                                <label class="block text-sm text-gray-700">Staff</label>
                                <select name="teacher_id" class="border rounded px-2 py-1">
                                    <option value="">All</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>{{ $t->first_name }} {{ $t->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">Month</label>
                                <input type="month" name="month" value="{{ request('month') }}" class="border rounded px-2 py-1">
                            </div>
                            <button class="px-3 py-2 bg-gray-200 rounded">Filter</button>
                        </form>
                        <a href="{{ route('payroll.payslips.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Generate</a>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payslip #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Salary</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($payslips as $p)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->payslip_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->teacher->first_name }} {{ $p->teacher->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ date('Y-m', strtotime($p->pay_month)) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($p->net_salary, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('payroll.payslips.show', $p) }}" class="text-blue-600 hover:text-blue-800 mr-3">View</a>
                                            <a href="{{ route('payroll.payslips.print', $p) }}" class="text-green-600 hover:text-green-800">PDF</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $payslips->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

