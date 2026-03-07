<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Select a Subscription Plan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-800">Choose the perfect plan for your school</h3>
                        <p class="text-gray-600 mt-2">
                            School: <span class="font-semibold">{{ $school->name }}</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($plans as $plan)
                            <div class="border rounded-lg p-6 flex flex-col hover:shadow-lg transition-shadow duration-200 {{ $plan->name === 'Premium' ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200' }}">
                                <div class="mb-4">
                                    <h4 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h4>
                                    <p class="text-3xl font-extrabold text-gray-900 mt-2">
                                        ${{ number_format($plan->price, 0) }}
                                        <span class="text-sm font-medium text-gray-500">/{{ $plan->billing_cycle }}</span>
                                    </p>
                                </div>

                                <ul class="mb-6 space-y-2 flex-1">
                                    @if(isset($plan->features) && is_array($plan->features))
                                        @foreach($plan->features as $feature)
                                            <li class="flex items-start text-sm text-gray-600">
                                                <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>

                                <form method="POST" action="{{ route('billing.choose-plan.store') }}" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200 font-semibold shadow-sm">
                                        Select {{ $plan->name }}
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
