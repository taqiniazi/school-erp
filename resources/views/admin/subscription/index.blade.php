<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('My Subscription') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <!-- Current Subscription Status -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="h5 fw-medium text-dark mb-0">Current Plan</h3>
                                <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $subscription->status === 'active' ? 'text-bg-success' : 'text-bg-warning' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <h4 class="h2 fw-bold text-dark">{{ $plan->name }}</h4>
                                <p class="text-secondary mb-0">${{ number_format($plan->price, 2) }} / {{ ucfirst($plan->billing_cycle) }}</p>
                            </div>

                            <div class="d-flex flex-column gap-3 mb-4">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-secondary">Start Date</span>
                                    <span class="fw-medium">{{ $subscription->current_period_start->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-secondary">Next Billing Date</span>
                                    <span class="fw-medium">{{ $subscription->current_period_end->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('admin.subscription.upgrade') }}" class="btn btn-info text-white fw-semibold btn-sm px-4">
                                    Change Plan
                                </a>
                                <a href="{{ route('billing.payment.history') }}" class="btn btn-outline-secondary fw-semibold btn-sm px-4">
                                    Billing History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body p-4">
                            <h3 class="h5 fw-medium text-dark mb-4">Usage & Limits</h3>

                            <div class="d-flex flex-column gap-4">
                                <!-- Students -->
                                <div>
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="fw-medium text-dark">Students</span>
                                        <span class="text-secondary">
                                            {{ $usage['students'] }} / {{ $plan->max_students ?? 'Unlimited' }}
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        @php
                                            $studentPercent = $plan->max_students ? min(100, ($usage['students'] / $plan->max_students) * 100) : 5;
                                            $studentColor = $studentPercent > 90 ? 'bg-danger' : 'bg-info';
                                        @endphp
                                        <div class="progress-bar {{ $studentColor }}" role="progressbar" style="width: {{ $studentPercent }}%" aria-valuenow="{{ $studentPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <!-- Teachers -->
                                <div>
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="fw-medium text-dark">Teachers</span>
                                        <span class="text-secondary">
                                            {{ $usage['teachers'] }} / {{ $plan->max_teachers ?? 'Unlimited' }}
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        @php
                                            $teacherPercent = $plan->max_teachers ? min(100, ($usage['teachers'] / $plan->max_teachers) * 100) : 5;
                                            $teacherColor = $teacherPercent > 90 ? 'bg-danger' : 'bg-info';
                                        @endphp
                                        <div class="progress-bar {{ $teacherColor }}" role="progressbar" style="width: {{ $teacherPercent }}%" aria-valuenow="{{ $teacherPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <!-- Campuses -->
                                <div>
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="fw-medium text-dark">Campuses</span>
                                        <span class="text-secondary">
                                            {{ $usage['campuses'] }} / {{ $plan->max_campuses ?? 'Unlimited' }}
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        @php
                                            $campusPercent = $plan->max_campuses ? min(100, ($usage['campuses'] / $plan->max_campuses) * 100) : 5;
                                            $campusColor = $campusPercent > 90 ? 'bg-danger' : 'bg-info';
                                        @endphp
                                        <div class="progress-bar {{ $campusColor }}" role="progressbar" style="width: {{ $campusPercent }}%" aria-valuenow="{{ $campusPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 small text-secondary">
                                <p class="mb-0">Need more resources? Upgrade your plan to increase these limits.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Features List -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                             <h3 class="h5 fw-medium text-dark mb-4">Plan Features</h3>
                             <div class="row row-cols-1 row-cols-md-3 g-3">
                                @foreach($plan->features ?? [] as $feature)
                                    <div class="col d-flex align-items-center small text-secondary">
                                        <svg style="width: 1.25rem; height: 1.25rem;" class="text-success me-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        </div>
    </div>
</x-app-layout>




