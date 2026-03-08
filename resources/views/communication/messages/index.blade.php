<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">
                {{ __('Inbox') }}
            </h2>
            <div class="btn-group">
                <a href="{{ route('communication.messages.create') }}" class="btn btn-primary">
                    <i class="fas fa-pen me-1"></i> {{ __('Compose') }}
                </a>
                <a href="{{ route('communication.messages.sent') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-paper-plane me-1"></i> {{ __('Sent Messages') }}
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">{{ __('From') }}</th>
                                <th scope="col">{{ __('Subject') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col" class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr class="{{ is_null($message->read_at) ? 'table-primary' : '' }}">
                                <td class="fw-bold">
                                    {{ $message->sender->name ?? 'Unknown' }}
                                </td>
                                <td>
                                    <a href="{{ route('communication.messages.show', $message) }}" class="text-decoration-none {{ is_null($message->read_at) ? 'fw-bold text-dark' : 'text-secondary' }}">
                                        {{ Str::limit($message->subject, 50) }}
                                    </a>
                                </td>
                                <td class="text-muted small">
                                    {{ $message->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('communication.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                                    <p class="mb-0">No messages in your inbox.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


