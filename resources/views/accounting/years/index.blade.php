<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Financial Years') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h3 class="lead fw-medium">Manage Financial Years</h3>
                        <a href="{{ route('financial-years.create') }}" class="btn btn-primary">
                            New Financial Year
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Name</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Start Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">End Date</th>
                                    <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Current</th>
                                    <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($years as $year)
                                    <tr>
                                        <td class="p-3 text-nowrap">{{ $year->name }}</td>
                                        <td class="p-3 text-nowrap">{{ $year->start_date }}</td>
                                        <td class="p-3 text-nowrap">{{ $year->end_date }}</td>
                                        <td class="p-3 text-nowrap">
                                            @if($year->is_current)
                                                <span class="badge rounded-pill text-bg-success">Current</span>
                                            @else
                                                <form action="{{ route('financial-years.set-current', $year) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-light">Set Current</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="p-3 text-nowrap text-end">
                                            <a href="{{ route('financial-years.edit', $year) }}" class="btn btn-sm btn-link text-decoration-none">Edit</a>
                                            <form action="{{ route('financial-years.destroy', $year) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this financial year?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-link text-danger text-decoration-none">Delete</button>
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





