<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fee Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium">Manage Invoices</h3>
                        @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('School Admin'))
                            <a href="{{ route('fee-invoices.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Generate Invoices (Bulk)
                            </a>
                        @endif
                    </div>

                    <!-- Filter Form -->
                    <form action="{{ route('fee-invoices.index') }}" method="GET" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <select name="class_id" class="w-full border rounded px-3 py-2">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="status" class="w-full border rounded px-3 py-2">
                                    <option value="">All Statuses</option>
                                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                </select>
                            </div>
                            <div>
                                <input type="text" name="student_id" placeholder="Student ID (Optional)" value="{{ request('student_id') }}" class="w-full border rounded px-3 py-2">
                            </div>
                            <div>
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Filter</button>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
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
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->student->first_name }} {{ $invoice->student->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->student->schoolClass->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->issue_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->due_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($invoice->total_amount + $invoice->fine_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($invoice->paid_amount + $invoice->discount_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($invoice->balance, 2) }}</td>
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
                                            @if($invoice->balance > 0)
                                                <a href="{{ route('fee-invoices.collect', $invoice->id) }}" class="text-green-600 hover:text-green-900">Collect</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
