﻿x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Edit Route') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('transport.routes.update', $route) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $route->name }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From</label>
                            <input type="text" name="start_point" value="{{ $route->start_point }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <input type="text" name="end_point" value="{{ $route->end_point }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fare</label>
                            <input type="number" step="0.01" min="0" name="fare" value="{{ $route->fare }}" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" @if($route->status==='active') selected @endif>Active</option>
                                <option value="inactive" @if($route->status==='inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('transport.routes.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





