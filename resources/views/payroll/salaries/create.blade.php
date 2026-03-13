﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('New Salary Structure') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container mx-auto px-3 px-4">
            <div class="bg-body overflow-hidden shadow-sm sm:rounded">
                <div class="p-4 bg-body border-b border-secondary">
                    <form action="{{ route('payroll.salaries.store') }}" method="POST">
                        @csrf
                        <div class="row row-cols-1 md:row-cols-1 row-cols-md-2 g-3">
                            <div class="mb-4">
                                <label class="d-block text-dark small fw-bold mb-2">Staff</label>
                                <select name="teacher_id" class="shadow appearance-none border rounded w-100 py-2 px-3" required>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="d-block text-dark small fw-bold mb-2">Basic Salary</label>
                                <input type="number" step="0.01" name="basic_salary" class="shadow appearance-none border rounded w-100 py-2 px-3" required>
                            </div>
                            <div class="mb-4">
                                <label class="d-block text-dark small fw-bold mb-2">Effective From</label>
                                <input type="date" name="effective_from" class="shadow appearance-none border rounded w-100 py-2 px-3">
                            </div>
                            <div class="mb-4">
                                <label class="d-block text-dark small fw-bold mb-2">Effective To</label>
                                <input type="date" name="effective_to" class="shadow appearance-none border rounded w-100 py-2 px-3">
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="bg-blue-500  text-white fw-bold py-2 px-4 rounded">
                                Save
                            </button>
                            <a href="{{ route('payroll.salaries.index') }}" class="text-info ">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





