<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subscription') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Subscription Status -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Current Plan</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-3xl font-bold text-gray-800">{{ $plan->name }}</h4>
                            <p class="text-gray-600">${{ number_format($plan->price, 2) }} / {{ ucfirst($plan->billing_cycle) }}</p>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Start Date</span>
                                <span class="font-medium">{{ $subscription->current_period_start->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Next Billing Date</span>
                                <span class="font-medium">{{ $subscription->current_period_end->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <a href="{{ route('admin.subscription.upgrade') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Change Plan
                            </a>
                            <a href="{{ route('billing.payment.history') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                Billing History
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Usage & Limits</h3>

                        <div class="space-y-6">
                            <!-- Students -->
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">Students</span>
                                    <span class="text-gray-600">
                                        {{ $usage['students'] }} / {{ $plan->max_students ?? 'Unlimited' }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $studentPercent = $plan->max_students ? min(100, ($usage['students'] / $plan->max_students) * 100) : 5;
                                        $studentColor = $studentPercent > 90 ? 'bg-red-600' : 'bg-blue-600';
                                    @endphp
                                    <div class="{{ $studentColor }} h-2.5 rounded-full" style="width: {{ $studentPercent }}%"></div>
                                </div>
                            </div>

                            <!-- Teachers -->
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">Teachers</span>
                                    <span class="text-gray-600">
                                        {{ $usage['teachers'] }} / {{ $plan->max_teachers ?? 'Unlimited' }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $teacherPercent = $plan->max_teachers ? min(100, ($usage['teachers'] / $plan->max_teachers) * 100) : 5;
                                        $teacherColor = $teacherPercent > 90 ? 'bg-red-600' : 'bg-blue-600';
                                    @endphp
                                    <div class="{{ $teacherColor }} h-2.5 rounded-full" style="width: {{ $teacherPercent }}%"></div>
                                </div>
                            </div>

                            <!-- Campuses -->
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">Campuses</span>
                                    <span class="text-gray-600">
                                        {{ $usage['campuses'] }} / {{ $plan->max_campuses ?? 'Unlimited' }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $campusPercent = $plan->max_campuses ? min(100, ($usage['campuses'] / $plan->max_campuses) * 100) : 5;
                                        $campusColor = $campusPercent > 90 ? 'bg-red-600' : 'bg-blue-600';
                                    @endphp
                                    <div class="{{ $campusColor }} h-2.5 rounded-full" style="width: {{ $campusPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-sm text-gray-500">
                            <p>Need more resources? Upgrade your plan to increase these limits.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features List -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                     <h3 class="text-lg font-medium text-gray-900 mb-4">Plan Features</h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($plan->features ?? [] as $feature)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $feature }}
                            </div>
                        @endforeach
                     </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
