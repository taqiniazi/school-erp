﻿@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Create Subject</h1>
    <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Subject Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Subject Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="theory">Theory</option>
                    <option value="practical">Practical</option>
                    <option value="both">Both</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success">Save Subject</button>
        </form>
    </div>
</div>
@endsection


