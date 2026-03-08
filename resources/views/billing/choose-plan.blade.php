<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            Select a Subscription Plan
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="mb-5 text-center">
                        <h3 class="h3 fw-bold text-dark">Choose the perfect plan for your school</h3>
                        <p class="text-secondary mt-2">
                            School: <span class="fw-semibold">{{ $school->name }}</span>
                        </p>
                    </div>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($plans as $plan)
                            <div class="col">
                                <div class="card h-100 shadow-sm {{ $plan->name === 'Premium' ? 'border-primary border-2 shadow-lg' : 'border' }}">
                                    <div class="card-body d-flex flex-column p-4">
                                        <div class="mb-4">
                                            <h4 class="h4 fw-bold text-dark">{{ $plan->name }}</h4>
                                            <p class="h2 fw-bold text-dark mt-2">
                                                ${{ number_format($plan->price, 0) }}
                                                <span class="small fw-medium text-secondary">/{{ $plan->billing_cycle }}</span>
                                            </p>
                                        </div>

                                        <ul class="list-unstyled mb-4 flex-grow-1 d-flex flex-column gap-2">
                                            @if(isset($plan->features) && is_array($plan->features))
                                                @foreach($plan->features as $feature)
                                                    <li class="d-flex align-items-start small text-secondary">
                                                        <svg style="width: 1.25rem; height: 1.25rem;" class="text-success me-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                            <button type="submit" class="btn btn-info text-white w-100 fw-semibold shadow-sm">
                                                Select {{ $plan->name }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




