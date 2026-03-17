<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0 fw-bold text-dark">
                            {{ $message->subject }}
                        </h2>
                        <a href="{{ route('communication.messages.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Inbox
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4 pb-3 border-bottom">
                            <div>
                                <div class="mb-1">
                                    <span class="fw-bold text-secondary">From:</span> 
                                    <span class="text-dark">{{ $message->sender->name }}</span>
                                </div>
                                <div>
                                    <span class="fw-bold text-secondary">To:</span> 
                                    <span class="text-dark">{{ $message->recipient->name }}</span>
                                </div>
                            </div>
                            <div class="text-muted small">
                                {{ $message->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>

                        <div class="message-content mb-5">
                            {!! $message->content !!}
                        </div>

                        <div class="d-flex gap-2 border-top pt-3">
                            <a href="{{ route('communication.messages.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                            @if($message->recipient_id == auth()->id())
                            <a href="{{ route('communication.messages.create') }}?recipient_id={{ $message->sender_id }}&subject=Re: {{ urlencode($message->subject) }}" class="btn btn-primary">
                                <i class="fas fa-reply me-1"></i> Reply
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


