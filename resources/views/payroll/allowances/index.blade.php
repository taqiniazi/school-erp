<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Allowances') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <form method="GET" class="d-flex align-items-end gap-2">
                            <div>
                                <label class="form-label small text-dark">Staff</label>
                                <select name="teacher_id" class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ ($teacherId == $t->id) ? 'selected' : '' }}>{{ optional($t->user)->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-sm btn-light border">Filter</button>
                        </form>
                        <a href="{{ route('payroll.allowances.create') }}" class="btn btn-primary">New</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Staff</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Value</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Active</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allowances as $a)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ optional(optional($a->teacher)->user)->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $a->name }}</td>
                                        <td class="p-3 text-nowrap">
                                            {{ $a->is_percentage ? $a->amount.'%' : number_format($a->amount, 2) }}
                                        </td>
                                        <td class="p-3 text-nowrap">
                                            <span class="badge {{ $a->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                                {{ $a->is_active ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('payroll.allowances.edit', $a) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('payroll.allowances.destroy', $a) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this allowance?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
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




