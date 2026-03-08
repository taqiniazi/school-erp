<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">
                {{ __('Events Calendar') }}
            </h2>
            @role('Super Admin|School Admin|Teacher')
            <a href="{{ route('communication.events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> {{ __('Add Event') }}
            </a>
            @endrole
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-primary fw-bold text-uppercase small">
                                {{ $event->start_date->format('M d, Y') }}
                            </span>
                            @if($event->location)
                            <span class="badge bg-light text-dark border">
                                {{ $event->location }}
                            </span>
                            @endif
                        </div>
                        <h3 class="h5 fw-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-muted small mb-3">
                            {{ Str::limit($event->description, 100) }}
                        </p>
                        <div class="small text-secondary mb-3">
                            <i class="far fa-clock me-1"></i>
                            {{ $event->start_date->format('h:i A') }} 
                            @if($event->end_date)
                            - {{ $event->end_date->format('h:i A') }}
                            @endif
                        </div>
                        @role('Super Admin|School Admin')
                        <div class="d-flex justify-content-end g-2 pt-3 border-top">
                            <a href="{{ route('communication.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('communication.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        <i class="far fa-calendar-times fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">No upcoming events found.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
</x-app-layout>


