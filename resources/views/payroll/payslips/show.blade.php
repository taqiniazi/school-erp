<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payslip') }} #{{ $payslip->payslip_no }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <div>
                            <div class="text-lg font-semibold">{{ $payslip->teacher->first_name }} {{ $payslip->teacher->last_name }}</div>
                            <div class="text-sm text-gray-600">Month: {{ date('Y-m', strtotime($payslip->pay_month)) }}</div>
                        </div>
                        <a href="{{ route('payroll.payslips.print', $payslip) }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Download PDF</a>
                    </div>

                    <div class="mb-4">
                        <div class="font-semibold mb-2">Earnings</div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2">Basic Salary</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($payslip->basic_salary, 2) }}</td>
                                </tr>
                                @foreach($payslip->items->where('type', 'allowance') as $item)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->name }}</td>
                                        <td class="px-4 py-2 text-right">{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <div class="font-semibold mb-2">Deductions</div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($payslip->items->where('type', 'deduction') as $item)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->name }}</td>
                                        <td class="px-4 py-2 text-right">{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-2" colspan="2">No deductions</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mt-4">
                        <div class="text-right">
                            <div>Total Allowances: <span class="font-semibold">{{ number_format($payslip->total_allowances, 2) }}</span></div>
                            <div>Total Deductions: <span class="font-semibold">{{ number_format($payslip->total_deductions, 2) }}</span></div>
                            <div class="text-lg">Net Salary: <span class="font-bold">{{ number_format($payslip->net_salary, 2) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

