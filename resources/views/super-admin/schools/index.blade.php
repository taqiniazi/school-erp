@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">Schools</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Schools List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Admin</th>
                            <th>Students</th>
                            <th>Teachers</th>
                            <th>Campuses</th>
                            <th>Subscription</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $s)
                            @php
                                $sub = $s->subscriptions->first();
                            @endphp
                            <tr>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->admin ? $s->admin->name : 'No Admin' }}</td>
                                <td>{{ $s->students_count }}</td>
                                <td>{{ $s->teachers_count }}</td>
                                <td>{{ $s->campuses_count }}</td>
                                <td>
                                    {{ optional(optional($sub)->plan)->name ?: 'â€”' }}
                                    {{ $sub ? '(' . ucfirst($sub->status) . ')' : '' }}
                                </td>
                                <td>
                                    @if($s->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$s->is_active)
                                        <form action="{{ route('super-admin.schools.activate', $s) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Activate</button>
                                        </form>
                                    @else
                                        <form action="{{ route('super-admin.schools.deactivate', $s) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-secondary btn-sm">Deactivate</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $schools->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


