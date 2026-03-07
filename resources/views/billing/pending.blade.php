<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Subscription Pending
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <div class="mb-4">
                        <svg class="h-16 w-16 text-yellow-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Payment Verification Pending</h3>
                    <p class="text-gray-600 mb-6">
                        Thank you for your payment! We have received your subscription request and payment proof.<br>
                        Our team is verifying your payment. This process usually takes 1-2 hours.
                    </p>
                    <p class="text-sm text-gray-500 mb-6">
                        You will receive an email once your subscription is active.
                    </p>
                    
                    <a href="{{ route('billing.payment.history') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View Payment History
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
