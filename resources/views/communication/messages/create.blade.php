﻿﻿﻿<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-body py-3">
                        <h2 class="h5 mb-0 fw-bold">
                            {{ __('Compose Message') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('communication.messages.store') }}">
                            @csrf
                            @php
                                $selectedRecipient = old('recipient_id', request('recipient_id'));
                                $recipientsByRole = $recipients
                                    ->groupBy(function ($user) {
                                        return $user->roles->pluck('name')->first() ?? 'Other';
                                    })
                                    ->sortKeys();
                            @endphp

                            <!-- Recipient -->
                            <div class="mb-3">
                                <label for="recipient_id" class="form-label">{{ __('To') }}</label>
                                <select id="recipient_id" name="recipient_id" class="form-select @error('recipient_id') is-invalid @enderror" required>
                                    <option value="">{{ __('Select Recipient') }}</option>
                                    @if(auth()->user()?->hasRole(['Super Admin', 'School Admin']))
                                        <optgroup label="{{ __('Groups') }}">
                                            <option value="group:staff" {{ $selectedRecipient === 'group:staff' ? 'selected' : '' }}>{{ __('All Staff') }}</option>
                                            <option value="group:teachers" {{ $selectedRecipient === 'group:teachers' ? 'selected' : '' }}>{{ __('All Teachers') }}</option>
                                            <option value="group:students" {{ $selectedRecipient === 'group:students' ? 'selected' : '' }}>{{ __('All Students') }}</option>
                                        </optgroup>
                                    @endif
                                    @foreach($recipientsByRole as $roleName => $roleRecipients)
                                        <optgroup label="{{ $roleName }}">
                                            @foreach($roleRecipients as $recipient)
                                                <option value="{{ $recipient->id }}" {{ (string) $selectedRecipient === (string) $recipient->id ? 'selected' : '' }}>
                                                    {{ $recipient->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('recipient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subject -->
                            <div class="mb-3">
                                <label for="subject" class="form-label">{{ __('Subject') }}</label>
                                <input id="subject" class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" value="{{ old('subject', request('subject')) }}" required autofocus />
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="email_content" class="form-label d-block w-100">{{ __('Message') }}</label>
                                <textarea id="email_content" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                                <div id="email_content_editor" class="border rounded bg-white"></div>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> {{ __('Send Message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('styles')
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/css/quill.snow.css') }}" rel="stylesheet">
    <style>
        .select2-container { width: 100% !important; }
        .select2-container--default .select2-selection--single { height: calc(2.375rem + 2px); border: 1px solid var(--bs-border-color); border-radius: .375rem; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: calc(2.375rem); padding-left: .75rem; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: calc(2.375rem); right: .75rem; }
        #email_content_editor .ql-container { min-height: 200px; }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/js/quill.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) {
                window.jQuery('#recipient_id').select2({
                    width: '100%',
                    placeholder: @json(__('Select Recipient'))
                });

                if (document.getElementById('recipient_id').classList.contains('is-invalid')) {
                    window.jQuery('#recipient_id')
                        .next('.select2-container')
                        .find('.select2-selection')
                        .addClass('is-invalid');
                }
            }

            var textarea = document.getElementById('email_content');
            var editorEl = document.getElementById('email_content_editor');
            var form = textarea.closest('form');

            if (window.Quill && editorEl) {
                var quill = new window.Quill(editorEl, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                if (textarea.value) {
                    quill.clipboard.dangerouslyPasteHTML(textarea.value);
                }

                form.addEventListener('submit', function (e) {
                    var text = quill.getText().trim();
                    textarea.value = text.length ? quill.root.innerHTML : '';
                    if (!textarea.value) {
                        e.preventDefault();
                        editorEl.classList.add('border-danger');
                    }
                });
            }
        });
    </script>
@endpush
