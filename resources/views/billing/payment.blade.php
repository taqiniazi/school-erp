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
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Payment Options</h3>

                        <!-- Online Payments -->
                        <div class="mb-8 space-y-4">
                            <h4 class="font-bold text-gray-700 mb-2">Instant Payment (Recommended)</h4>
                            
                            <form method="POST" action="{{ route('billing.payment.stripe', $plan->id) }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-semibold shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.895-1.356 2.472-1.356 1.883 0 3.732.536 4.673.966l.72-2.49c-.833-.306-2.736-.71-4.71-.71-3.837 0-6.19 1.93-6.19 5.093 0 3.257 2.766 4.706 5.232 5.568 2.435.853 2.924 1.547 2.924 2.455 0 1.258-1.545 1.767-3.415 1.767-2.316 0-4.636-.79-5.632-1.28l-.774 2.613c.96.444 3.033.864 5.34.864 4.354 0 7.005-2.115 7.005-5.385-.015-3.056-2.583-4.475-4.283-5.088z"/></svg>
                                    Pay with Stripe
                                </button>
                            </form>

                            <form method="POST" action="{{ route('billing.payment.paypal', $plan->id) }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 font-semibold shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337l.756-3.792h3.25c4.326 0 7.733-1.683 8.763-6.248.514-2.28-.106-4.01-1.786-5.234-1.678-1.226-4.22-1.57-7.23-1.57H4.354L1.706 21.337h5.37zm2.25-13.62h2.246c2.565 0 4.145.45 4.545 2.22.25 1.11-.14 2.11-1.24 2.825-.86.56-2.26.795-3.92.795H8.38L9.326 7.717z"/></svg>
                                    Pay with PayPal
                                </button>
                            </form>
                        </div>

                        <hr class="mb-6">

                        <!-- Manual Payment -->
                        <h4 class="font-bold text-gray-700 mb-4">Manual Transfer & Proof Upload</h4>

                        <!-- Payment Methods Info -->
                        <div class="space-y-6 mb-8">
                            <div class="border rounded p-4 bg-gray-50">
                                <h4 class="font-bold text-green-600 mb-2">Easypaisa / Jazzcash</h4>
                                <p class="text-sm text-gray-600">Account Number: <strong>0300-1234567</strong></p>
                                <p class="text-sm text-gray-600">Account Title: <strong>School ERP Corp</strong></p>
                            </div>

                            <div class="border rounded p-4 bg-gray-50">
                                <h4 class="font-bold text-blue-600 mb-2">Bank Transfer / Wise / Payoneer</h4>
                                <p class="text-sm text-gray-600">Bank Name: <strong>HBL</strong></p>
                                <p class="text-sm text-gray-600">Account Number: <strong>1234-5678-9012-3456</strong></p>
                                <p class="text-sm text-gray-600">Wise Email: <strong>payments@schoolerp.com</strong></p>
                                <p class="text-sm text-gray-600">Payoneer ID: <strong>12345678</strong></p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('billing.payment.store', $plan->id) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Method</option>
                                    <option value="easypaisa">Easypaisa</option>
                                    <option value="jazzcash">Jazzcash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="wise">Wise</option>
                                    <option value="payoneer">Payoneer</option>
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
                                <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 font-semibold shadow-sm">
                                    Submit Manual Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
