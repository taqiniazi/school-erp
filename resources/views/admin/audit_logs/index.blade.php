<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Audit Logs') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">User</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Event</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Auditable Type</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Auditable ID</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">IP Address</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Time</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td class="p-3 text-nowrap small fw-medium text-dark">
                                            {{ $log->user->name ?? 'System' }} ({{ $log->user_id }})
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            <span class="badge rounded-pill 
                                                @if($log->event == 'created') text-bg-success 
                                                @elseif($log->event == 'updated') text-bg-primary 
                                                @elseif($log->event == 'deleted') text-bg-danger 
                                                @else text-bg-light @endif">
                                                {{ ucfirst($log->event) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            {{ class_basename($log->auditable_type) }}
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            {{ $log->auditable_id }}
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            {{ $log->ip_address }}
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="p-3 text-nowrap small text-secondary">
                                            <a href="{{ route('admin.audit-logs.show', $log->id) }}" class="btn btn-sm btn-success text-decoration-none">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



