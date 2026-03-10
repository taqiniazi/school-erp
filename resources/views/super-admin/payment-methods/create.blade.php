﻿@extends('layouts.app')

@section('title', 'Add Payment Method')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark">Add Payment Method</h1>
        <a href="{{ route('super-admin.payment-methods.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">New Payment Method</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('super-admin.payment-methods.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Method Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="manual" {{ old('type') == 'manual' ? 'selected' : '' }}>Manual (Bank Transfer, Cash, etc.)</option>
                            <option value="gateway" {{ old('type') == 'gateway' ? 'selected' : '' }}>Payment Gateway (Stripe, PayPal)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3" id="instructions_group">
                    <label for="instructions" class="form-label">Instructions</label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="3">{{ old('instructions') }}</textarea>
                    <div class="form-text">Instructions for the user on how to make the payment.</div>
                    @error('instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="account_details_group">
                    <label class="form-label">Account Details (Key-Value Pairs)</label>
                    <div id="account_details_container">
                        {{-- Dynamic fields will be added here --}}
                        @if(old('account_details'))
                            @foreach(old('account_details') as $key => $value)
                                <div class="input-group mb-2 account-detail-row">
                                    <input type="text" class="form-control" name="account_details_keys[]" value="{{ $key }}" placeholder="Key (e.g. Bank Name)">
                                    <input type="text" class="form-control" name="account_details_values[]" value="{{ $value }}" placeholder="Value (e.g. HBL)">
                                    <button type="button" class="btn btn-danger remove-detail"><i class="fas fa-trash"></i></button>
                                </div>
                            @endforeach
                        @else
                             <div class="input-group mb-2 account-detail-row">
                                <input type="text" class="form-control" name="account_details_keys[]" placeholder="Key (e.g. Bank Name)">
                                <input type="text" class="form-control" name="account_details_values[]" placeholder="Value (e.g. HBL)">
                                <button type="button" class="btn btn-danger remove-detail"><i class="fas fa-trash"></i></button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-success mt-2" id="add_detail_btn">
                        <i class="fas fa-plus"></i> Add Detail Field
                    </button>
                    <div class="form-text">Add details like Account Number, IBAN, Branch Code, etc.</div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Create Payment Method</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const instructionsGroup = document.getElementById('instructions_group');
        const accountDetailsGroup = document.getElementById('account_details_group');
        const container = document.getElementById('account_details_container');
        const addBtn = document.getElementById('add_detail_btn');

        function toggleFields() {
            if (typeSelect.value === 'gateway') {
                instructionsGroup.style.display = 'none';
                accountDetailsGroup.style.display = 'none';
            } else {
                instructionsGroup.style.display = 'd-block';
                accountDetailsGroup.style.display = 'd-block';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Initial check

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'input-group mb-2 account-detail-row';
            row.innerHTML = `
                <input type="text" class="form-control" name="account_details_keys[]" placeholder="Key (e.g. Bank Name)">
                <input type="text" class="form-control" name="account_details_values[]" placeholder="Value (e.g. HBL)">
                <button type="button" class="btn btn-danger remove-detail"><i class="fas fa-trash"></i></button>
            `;
            container.appendChild(row);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-detail')) {
                const row = e.target.closest('.account-detail-row');
                if (container.querySelectorAll('.account-detail-row').length > 1) {
                    row.remove();
                } else {
                    // Clear inputs instead of removing the last one
                    row.querySelectorAll('input').forEach(input => input.value = '');
                }
            }
        });
        
        // Form submission handler to combine keys and values into account_details array
        document.querySelector('form').addEventListener('submit', function(e) {
            const keys = document.querySelectorAll('input[name="account_details_keys[]"]');
            const values = document.querySelectorAll('input[name="account_details_values[]"]');
            
            // Remove existing d-none inputs if any
            document.querySelectorAll('input[name^="account_details["]').forEach(el => el.remove());

            keys.forEach((keyInput, index) => {
                const key = keyInput.value.trim();
                const value = values[index].value.trim();
                
                if (key && value) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'd-none';
                    hiddenInput.name = `account_details[${key}]`;
                    hiddenInput.value = value;
                    this.appendChild(hiddenInput);
                }
            });
        });
    });
</script>
@endpush
@endsection



