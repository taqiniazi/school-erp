<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice Details') }} - {{ $feeInvoice->invoice_no }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium">Invoice #{{ $feeInvoice->invoice_no }}</h3>
                        <div>
                            <a href="{{ route('fee-invoices.print', $feeInvoice->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">
                                Download PDF
                            </a>
                            @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin'))
                                <a href="{{ route('fee-invoices.edit', $feeInvoice->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 mr-2">
                                    Edit
                                </a>
                            @endif
                            @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin') || Auth::user()->hasRole('Teacher'))
                                @if($feeInvoice->balance > 0)
                                    <a href="{{ route('fee-invoices.collect', $feeInvoice->id) }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                        Collect Payment
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h4 class="font-bold">Student Details:</h4>
                            <p>Name: {{ $feeInvoice->student->first_name }} {{ $feeInvoice->student->last_name }}</p>
                            <p>Class: {{ $feeInvoice->student->schoolClass->name }}</p>
                            <p>Admission No: {{ $feeInvoice->student->admission_number }}</p>
                        </div>
                        <div class="text-right">
                            <h4 class="font-bold">Invoice Details:</h4>
                            <p>Issue Date: {{ $feeInvoice->issue_date }}</p>
                            <p>Due Date: {{ $feeInvoice->due_date }}</p>
                            <p>Status: <span class="font-bold uppercase {{ $feeInvoice->status == 'paid' ? 'text-green-600' : 'text-red-600' }}">{{ $feeInvoice->status }}</span></p>
                        </div>
                    </div>

                    <h4 class="font-bold mb-2">Fee Items:</h4>
                    <table class="min-w-full divide-y divide-gray-200 mb-6">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($feeInvoice->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">{{ number_format($item->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <!-- Summary -->
                            <tr class="bg-gray-50 font-bold">
                                <td class="px-6 py-4 text-right">Subtotal</td>
                                <td class="px-6 py-4 text-right">{{ number_format($feeInvoice->total_amount, 2) }}</td>
                            </tr>
                            @if($feeInvoice->fine_amount > 0)
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 text-right text-red-600">Fine</td>
                                    <td class="px-6 py-4 text-right text-red-600">{{ number_format($feeInvoice->fine_amount, 2) }}</td>
                                </tr>
                            @endif
                            @if($feeInvoice->discount_amount > 0)
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 text-right text-green-600">Discount</td>
                                    <td class="px-6 py-4 text-right text-green-600">-{{ number_format($feeInvoice->discount_amount, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="bg-gray-100 font-bold text-lg">
                                <td class="px-6 py-4 text-right">Total Payable</td>
                                <td class="px-6 py-4 text-right">{{ number_format($feeInvoice->total_amount + $feeInvoice->fine_amount - $feeInvoice->discount_amount, 2) }}</td>
                            </tr>
                            <tr class="bg-gray-100 font-bold">
                                <td class="px-6 py-4 text-right">Paid Amount</td>
                                <td class="px-6 py-4 text-right text-green-600">{{ number_format($feeInvoice->paid_amount, 2) }}</td>
                            </tr>
                            <tr class="bg-gray-200 font-bold text-lg">
                                <td class="px-6 py-4 text-right">Balance Due</td>
                                <td class="px-6 py-4 text-right text-red-600">{{ number_format($feeInvoice->balance, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="font-bold mb-2">Payment History:</h4>
                    @if($feeInvoice->payments->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collected By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($feeInvoice->payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_method }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->transaction_reference }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->collectedBy->name ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 italic">No payments recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
