@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Create Class</h1>
    <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Numeric Value</label>
                <input type="number" name="numeric_value" class="form-control" value="{{ old('numeric_value') }}" required>
                @error('numeric_value') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Class Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success">Save Class</button>
        </form>
    </div>
</div>
@endsection


