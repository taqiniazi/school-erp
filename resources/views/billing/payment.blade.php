<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout - {{ $plan->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-fit">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-600">Plan Name</span>
                            <span class="font-medium">{{ $plan->name }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-600">Billing Cycle</span>
                            <span class="font-medium">{{ ucfirst($plan->billing_cycle) }}</span>
                        </div>
                        <div class="flex justify-between py-4 text-xl font-bold">
                            <span>Total Amount</span>
                            <span>Rs. {{ number_format($plan->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Details & Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Payment Instructions</h3>

                        <!-- Payment Methods Info -->
                        <div class="space-y-6 mb-8">
                            <div class="border rounded p-4 bg-gray-50">
                                <h4 class="font-bold text-green-600 mb-2">Easypaisa / Jazzcash</h4>
                                <p class="text-sm text-gray-600">Account Number: <strong>0300-1234567</strong></p>
                                <p class="text-sm text-gray-600">Account Title: <strong>School ERP Corp</strong></p>
                            </div>

                            <div class="border rounded p-4 bg-gray-50">
                                <h4 class="font-bold text-blue-600 mb-2">Bank Transfer</h4>
                                <p class="text-sm text-gray-600">Bank Name: <strong>HBL</strong></p>
                                <p class="text-sm text-gray-600">Account Number: <strong>1234-5678-9012-3456</strong></p>
                                <p class="text-sm text-gray-600">Account Title: <strong>School ERP Corp</strong></p>
                            </div>
                        </div>

                        <hr class="mb-6">

                        <h3 class="text-lg font-bold text-gray-900 mb-4">Upload Payment Proof</h3>
                        
                        <form method="POST" action="{{ route('billing.payment.store', $plan->id) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Method</option>
                                    <option value="easypaisa">Easypaisa</option>
                                    <option value="jazzcash">Jazzcash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction ID / Reference No.</label>
                                <input type="text" name="transaction_reference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="e.g. TRX-123456789">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upload Screenshot (Proof)</label>
                                <input type="file" name="proof_file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100" required>
                                <p class="text-xs text-gray-500 mt-1">Max 2MB. JPG, PNG only.</p>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold shadow-sm">
                                    Submit Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
