﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Performance Review') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('hr.performance.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold mb-2">Staff</label>
                            <select name="teacher_id" class="form-select" required>
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div>
                                <label class="form-label small fw-bold mb-2">Review Date</label>
                                <input type="date" name="review_date" class="form-control" required>
                            </div>
                            <div>
                                <label class="form-label small fw-bold mb-2">Score</label>
                                <input type="number" step="0.01" min="0" max="100" name="score" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="form-label small fw-bold mb-2">Remarks</label>
                            <textarea name="remarks" class="form-control"></textarea>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button class="btn btn-primary">Save</button>
                            <a href="{{ route('hr.performance.index') }}" class="btn btn-link text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






