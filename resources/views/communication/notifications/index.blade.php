<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div class="text-muted small">
                            {{ __('Unread') }}: {{ $unreadCount ?? 0 }}
                        </div>

                        <form method="POST" action="{{ route('ui.notifications.mark-all-read') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('Mark all read') }}
                            </button>
                        </form>
                    </div>

                    @if(isset($notifications) && $notifications->count())
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                @php
                                    $data = is_array($notification->data) ? $notification->data : [];
                                    $title = $data['title'] ?? __('Notification');
                                    $url = $data['url'] ?? null;
                                    $isUnread = $notification->read_at === null;
                                @endphp
                                <a href="{{ $url ?: '#' }}"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-start gap-3 {{ $isUnread ? 'fw-semibold' : '' }}">
                                    <div class="flex-grow-1">
                                        <div class="text-dark">{{ $title }}</div>
                                        <div class="small text-muted">{{ $notification->created_at?->diffForHumans() }}</div>
                                    </div>
                                    @if($isUnread)
                                        <span class="badge rounded-pill text-bg-primary">{{ __('New') }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">
                            <p class="mb-0">{{ __('No notifications yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
