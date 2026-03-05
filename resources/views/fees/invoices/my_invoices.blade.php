<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Fee History</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->issue_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->due_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format($invoice->total_amount + $invoice->fine_amount - $invoice->discount_amount, 2) }}
                                            @if($invoice->fine_amount > 0) <span class="text-xs text-red-500 block">+{{ $invoice->fine_amount }} Fine</span> @endif
                                            @if($invoice->discount_amount > 0) <span class="text-xs text-green-500 block">-{{ $invoice->discount_amount }} Disc</span> @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($invoice->paid_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold">{{ number_format($invoice->balance, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($invoice->status == 'paid') bg-green-100 text-green-800 
                                                @elseif($invoice->status == 'partial') bg-yellow-100 text-yellow-800
                                                @elseif($invoice->status == 'overdue') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('fee-invoices.show', $invoice->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                                            <a href="{{ route('fee-invoices.print', $invoice->id) }}" class="text-gray-600 hover:text-gray-900">PDF</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No invoices found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
