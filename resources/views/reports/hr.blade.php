﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('HR Reports') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <h3 class="lead fw-medium text-dark">Staff List</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-danger text-white">
                                Export PDF
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="btn btn-success text-white">
                                Export Excel
                            </a>
                        </div>
                    </div>

                    @if($staff->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover w-100 mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Department</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Designation</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Phone</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Email</th>
                                        <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $person)
                                        <tr>
                                            <td class="p-3 text-nowrap small fw-medium text-dark">{{ $person->teacher->user->name ?? 'N/A' }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $person->department }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $person->designation }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $person->phone }}</td>
                                            <td class="p-3 text-nowrap small text-secondary">{{ $person->teacher->user->email ?? 'N/A' }}</td>
                                            <td class="p-3 text-nowrap small">
                                                <span class="badge rounded-pill {{ $person->status === 'active' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                    {{ ucfirst($person->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">
                            <p class="mb-0">No staff records found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



