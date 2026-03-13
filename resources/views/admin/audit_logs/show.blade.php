﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Audit Log Details') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container mx-auto px-3 px-4">
            <div class="bg-body overflow-hidden shadow-sm sm:rounded">
                <div class="p-4 bg-body border-b border-secondary">
                    <div class="mb-4">
                        <a href="{{ route('admin.audit-logs.index') }}" class="text-primary ">&larr; Back to Logs</a>
                    </div>

                    <div class="row row-cols-1 md:row-cols-1 row-cols-md-2 g-4">
                        <div>
                            <h3 class="lead fw-medium text-dark">Event Information</h3>
                            <dl class="mt-2 small text-secondary">
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>User:</dt>
                                    <dd>{{ $auditLog->user->name ?? 'System' }} (ID: {{ $auditLog->user_id }})</dd>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>Event:</dt>
                                    <dd>{{ ucfirst($auditLog->event) }}</dd>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>Model:</dt>
                                    <dd>{{ $auditLog->auditable_type }} (ID: {{ $auditLog->auditable_id }})</dd>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>IP Address:</dt>
                                    <dd>{{ $auditLog->ip_address }}</dd>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>URL:</dt>
                                    <dd>{{ $auditLog->url }}</dd>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>User Agent:</dt>
                                    <dd>{{ $auditLog->user_agent }}</dd>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-b">
                                    <dt>Time:</dt>
                                    <dd>{{ $auditLog->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="lead fw-medium text-dark">Changes</h3>
                            <div class="mt-2">
                                <h4 class="small fw-medium text-dark">Old Values:</h4>
                                <pre class="bg-light p-2 rounded small table-responsive">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            <div class="mt-4">
                                <h4 class="small fw-medium text-dark">New Values:</h4>
                                <pre class="bg-light p-2 rounded small table-responsive">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


