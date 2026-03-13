﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Student Transport Assignments') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="mb-4">
                <a href="{{ route('transport.assignments.create') }}" class="btn btn-primary">New Assignment</a>
            </div>
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Student</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Route</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Vehicle</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Pickup</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Start</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Status</th>
                                    <th class="p-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $a)
                                    <tr>
                                        <td class="p-3 align-middle">
                                            {{ optional($a->student)->first_name }} {{ optional($a->student)->last_name }}
                                        </td>
                                        <td class="p-3 align-middle">{{ optional($a->route)->name }}</td>
                                        <td class="p-3 align-middle">{{ optional($a->vehicle)->registration_number }}</td>
                                        <td class="p-3 align-middle">{{ $a->pickup_point }}</td>
                                        <td class="p-3 align-middle">{{ optional($a->start_date)->format('Y-m-d') }}</td>
                                        <td class="p-3 align-middle">{{ ucfirst($a->status) }}</td>
                                        <td class="p-3 align-middle text-end">
                                            <form action="{{ route('transport.assignments.destroy', $a) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this assignment?')">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





