<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-semibold h4 text-dark lh-sm mb-0">Message Details</h2>
            <a href="{{ route('communication.email-sms.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="small text-secondary">Channel</div>
                            <div class="fw-semibold">{{ strtoupper($log->channel) }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="small text-secondary">Status</div>
                            <div class="fw-semibold">
                                @if($log->status === 'sent')
                                    <span class="badge bg-success">Sent</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small text-secondary">Sent At</div>
                            <div class="fw-semibold">{{ $log->sent_at?->format('Y-m-d H:i') ?? '-' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="small text-secondary">Recipients</div>
                            <div class="fw-semibold">{{ is_array($log->recipients) ? count($log->recipients) : 0 }}</div>
                        </div>
                        <div class="col-12">
                            <div class="small text-secondary">Recipient Group</div>
                            <div class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $log->recipient_group)) }}</div>
                        </div>
                        <div class="col-12">
                            <div class="small text-secondary">Subject</div>
                            <div class="fw-semibold">{{ $log->subject }}</div>
                        </div>
                        <div class="col-12">
                            <div class="small text-secondary">Message</div>
                            <div class="border rounded p-3 bg-light" style="white-space: pre-wrap;">{{ $log->message }}</div>
                        </div>
                        <div class="col-12">
                            <div class="small text-secondary">Recipients</div>
                            <div class="border rounded p-3 bg-light" style="white-space: pre-wrap;">{{ implode("\n", $log->recipients ?? []) }}</div>
                        </div>
                        @if($log->error_message)
                            <div class="col-12">
                                <div class="small text-secondary">Error</div>
                                <div class="alert alert-danger mb-0">{{ $log->error_message }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

