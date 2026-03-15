﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">{{ __('Routes') }}</h1>
            <a href="{{ route('transport.routes.create') }}" class="btn btn-primary">New Route</a>
        </div>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">From</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">To</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Fare</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($routes as $route)
                                    <tr>
                                        <td class="p-3 align-middle">{{ $route->name }}</td>
                                        <td class="p-3 align-middle">{{ $route->start_point }}</td>
                                        <td class="p-3 align-middle">{{ $route->end_point }}</td>
                                        <td class="p-3 align-middle text-end">{{ number_format($route->fare, 2) }}</td>
                                        <td class="p-3 align-middle">{{ ucfirst($route->status) }}</td>
                                        <td class="p-3 align-middle text-end">
                                            <a href="{{ route('transport.routes.edit', $route) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('transport.routes.destroy', $route) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this route?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




