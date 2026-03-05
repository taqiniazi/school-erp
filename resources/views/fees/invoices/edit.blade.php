<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Invoice') }} #{{ $feeInvoice->invoice_no }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('fee-invoices.update', $feeInvoice) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Student Name:</label>
                                <p class="text-gray-900">{{ $feeInvoice->student->first_name }} {{ $feeInvoice->student->last_name }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <label for="issue_date" class="block text-gray-700 text-sm font-bold mb-2">Issue Date:</label>
                                <input type="date" name="issue_date" id="issue_date" value="{{ $feeInvoice->issue_date }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-4">
                                <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date:</label>
                                <input type="date" name="due_date" id="due_date" value="{{ $feeInvoice->due_date }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-4">
                                <label for="fine_amount" class="block text-gray-700 text-sm font-bold mb-2">Fine Amount:</label>
                                <input type="number" step="0.01" name="fine_amount" id="fine_amount" value="{{ $feeInvoice->fine_amount }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label for="discount_amount" class="block text-gray-700 text-sm font-bold mb-2">Discount Amount:</label>
                                <input type="number" step="0.01" name="discount_amount" id="discount_amount" value="{{ $feeInvoice->discount_amount }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            
                             <div class="mb-4 md:col-span-2">
                                <label for="remarks" class="block text-gray-700 text-sm font-bold mb-2">Remarks:</label>
                                <textarea name="remarks" id="remarks" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $feeInvoice->remarks }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Invoice
                            </button>
                            <a href="{{ route('fee-invoices.show', $feeInvoice) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>