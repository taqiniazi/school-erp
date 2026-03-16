<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-semibold h4 text-dark lh-sm mb-0">Email / SMS</h2>
            <a href="{{ route('communication.email-sms.create') }}" class="btn btn-primary">Compose</a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Channel</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Recipients</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="p-3 text-nowrap">{{ strtoupper($log->channel) }}</td>
                                        <td class="p-3 text-nowrap">
                                            {{ ucfirst(str_replace('_', ' ', $log->recipient_group)) }} ({{ is_array($log->recipients) ? count($log->recipients) : 0 }})
                                        </td>
                                        <td class="p-3">{{ $log->subject }}</td>
                                        <td class="p-3 text-nowrap">
                                            @if($log->status === 'sent')
                                                <span class="badge bg-success">Sent</span>
                                            @else
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('communication.email-sms.show', $log) }}" class="btn btn-sm btn-outline-info">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-3 text-center text-secondary">No messages yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
