<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collect Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('fee-invoices.pay', $feeInvoice->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount to Pay (Max: {{ number_format($feeInvoice->balance, 2) }}):</label>
                                <input type="number" step="0.01" name="amount" id="amount" max="{{ $feeInvoice->balance }}" value="{{ $feeInvoice->balance }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div class="mb-4">
                                <label for="payment_date" class="block text-gray-700 text-sm font-bold mb-2">Payment Date:</label>
                                <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div class="mb-4">
                                <label for="payment_method" class="block text-gray-700 text-sm font-bold mb-2">Payment Method:</label>
                                <select name="payment_method" id="payment_method" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Online">Online</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="transaction_reference" class="block text-gray-700 text-sm font-bold mb-2">Transaction Reference (Optional):</label>
                                <input type="text" name="transaction_reference" id="transaction_reference" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4 col-span-2">
                                <label for="remarks" class="block text-gray-700 text-sm font-bold mb-2">Remarks (Optional):</label>
                                <textarea name="remarks" id="remarks" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Process Payment
                            </button>
                            <a href="{{ route('fee-invoices.show', $feeInvoice->id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
