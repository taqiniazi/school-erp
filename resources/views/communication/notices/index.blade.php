<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-dark">Notices Board</h2>
            @role('Super Admin|School Admin|Teacher')
            <a href="{{ route('communication.notices.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Post New Notice
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
            @forelse($notices as $notice)
            <div class="col-12">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="h5 card-title fw-bold mb-1">
                                    @if($notice->type == 'urgent')
                                    <span class="badge bg-danger me-2">URGENT</span>
                                    @elseif($notice->type == 'event')
                                    <span class="badge bg-info text-dark me-2">EVENT</span>
                                    @endif
                                    {{ $notice->title }}
                                </h3>
                                <p class="card-subtitle text-muted small">
                                    Posted by {{ $notice->creator->name ?? 'Unknown' }} 
                                    to {{ ucfirst($notice->audience_role) }} 
                                    on {{ $notice->published_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                            @role('Super Admin|School Admin')
                            <div class="btn-group">
                                <a href="{{ route('communication.notices.edit', $notice) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('communication.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                            @endrole
                        </div>
                        <div class="card-text">
                            {!! nl2br(e($notice->content)) !!}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">No notices found.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $notices->links() }}
        </div>
    </div>
</x-app-layout>

