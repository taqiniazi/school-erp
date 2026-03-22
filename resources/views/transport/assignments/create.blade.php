﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Assign Student to Transport') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('transport.student-transport.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <select name="student_id" class="form-select" required>
                                @foreach($students as $s)
                                    <option value="{{ $s->id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Route</label>
                            <select name="transport_route_id" class="form-select" required>
                                @foreach($routes as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vehicle</label>
                            <select name="vehicle_id" class="form-select">
                                <option value="">None</option>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}">{{ $v->registration_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pickup Point</label>
                            <input type="text" name="pickup_point" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary">Assign</button>
                            <a href="{{ route('transport.student-transport.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




