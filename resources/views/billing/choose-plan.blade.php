<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Select a Subscription Plan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <p class="text-gray-700">
                        Your admin account must have an active subscription before you can use the ERP.
                    </p>
                    @if ($school)
                        <p class="text-gray-600 mt-2">School: {{ $school->name }}</p>
                    @endif
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('billing.choose-plan.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-700">Plan</label>
                            <select name="plan_id" class="mt-1 w-full border rounded p-2" required>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">
                                        {{ $plan->name }} ({{ $plan->billing_cycle }}) - {{ $plan->price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-2">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Activate Subscription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
