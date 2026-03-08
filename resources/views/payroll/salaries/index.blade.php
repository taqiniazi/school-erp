<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Staff Salaries') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h3 class="lead fw-medium">Active Salary Structures</h3>
                        <a href="{{ route('payroll.salaries.create') }}" class="btn btn-primary">New</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Staff</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Basic Salary</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Effective</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaries as $s)
                                    <tr>
                                        <td class="p-3 align-middle text-nowrap">{{ $s->teacher->first_name }} {{ $s->teacher->last_name }}</td>
                                        <td class="p-3 align-middle text-nowrap">{{ number_format($s->basic_salary, 2) }}</td>
                                        <td class="p-3 align-middle text-nowrap">{{ $s->effective_from }} @if($s->effective_to) - {{ $s->effective_to }} @endif</td>
                                        <td class="p-3 align-middle text-nowrap text-end">
                                            <a href="{{ route('payroll.salaries.edit', $s) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                            <form action="{{ route('payroll.salaries.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
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





