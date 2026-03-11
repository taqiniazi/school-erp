﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Leave Request') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 border-bottom">
                    <form method="POST" action="{{ route('hr.leave.store') }}">
                        @csrf
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div>
                                <label class="form-label small fw-bold text-dark">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div>
                                <label class="form-label small fw-bold text-dark">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-dark">Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="sick">Sick</option>
                                    <option value="casual">Casual</option>
                                    <option value="annual">Annual</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-dark">Reason</label>
                                <textarea name="reason" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button class="btn btn-primary px-4">Submit</button>
                            <a href="{{ route('hr.leave.my') }}" class="btn btn-link text-decoration-none text-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






