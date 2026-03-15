﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('Sent Messages') }}</h1>
            <div class="btn-group">
                <a href="{{ route('communication.messages.create') }}" class="btn btn-primary">
                    <i class="fas fa-pen me-1"></i> {{ __('Compose') }}
                </a>
                <a href="{{ route('communication.messages.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-inbox me-1"></i> {{ __('Back to Inbox') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
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
                                <th scope="col">{{ __('To') }}</th>
                                <th scope="col">{{ __('Subject') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col" class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr>
                                <td class="fw-bold">
                                    {{ $message->recipient->name ?? 'Unknown' }}
                                </td>
                                <td>
                                    <a href="{{ route('communication.messages.show', $message) }}" class="text-decoration-none text-dark">
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
                                    <i class="fas fa-paper-plane fa-3x mb-3 text-secondary"></i>
                                    <p class="mb-0">No sent messages.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
