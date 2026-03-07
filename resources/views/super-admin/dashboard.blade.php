<x-app-layout>
    <x-slot name="header">
        {{ __('Super Admin Dashboard') }}
    </x-slot>
    
    <div class="row g-4 mb-4">
        <!-- Schools -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Schools</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalSchools }}</div>
                    <div class="small text-muted mt-1">Active {{ $activeSchools }} • Suspended {{ $suspendedSchools }}</div>
                </div>
            </div>
        </div>
        
        <!-- Admin Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Admin Users</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $adminUsers }}</div>
                </div>
            </div>
        </div>
        
        <!-- Active Subscriptions -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">Active Subscriptions</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $activeSubs }}</div>
                </div>
            </div>
        </div>
        
        <!-- MRR -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="text-uppercase text-muted small fw-bold mb-1">MRR</div>
                    <div class="h3 mb-0 fw-bold text-dark">${{ number_format($mrr, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Schools -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 card-title">Recent Schools</h5>
                    <a href="{{ route('super-admin.schools.index') }}" class="btn btn-sm btn-link text-decoration-none">Manage</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentSchools as $s)
                                    <tr>
                                        <td class="ps-4">{{ $s->name }}</td>
                                        <td>
                                            <span class="badge {{ $s->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $s->is_active ? 'Active' : 'Suspended' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center py-3 text-muted">No schools found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Subscriptions -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 card-title">Recent Subscriptions</h5>
                    <a href="{{ route('super-admin.plans.index') }}" class="btn btn-sm btn-link text-decoration-none">Plans</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">School</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subscriptions as $sub)
                                    <tr>
                                        <td class="ps-4">{{ optional($sub->school)->name }}</td>
                                        <td>{{ optional($sub->plan)->name }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $sub->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center py-3 text-muted">No subscriptions found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white">
            <h5 class="mb-0 card-title">Active Plans</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @forelse ($plans as $plan)
                    <div class="col-md-4">
                        <div class="card h-100 border">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $plan->name }}</h5>
                                <p class="card-text text-muted mb-2">
                                    Limit: {{ $plan->max_students === -1 ? 'Unlimited' : $plan->max_students }} Students
                                </p>
                                <h6 class="text-primary mb-0">
                                    ${{ number_format($plan->price_monthly, 2) }} / mo
                                </h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No plans available</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
