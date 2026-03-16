<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">Compose</h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('communication.email-sms.store') }}">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="d-block text-dark small fw-bold mb-2">Channel</label>
                                        <select name="channel" class="form-select" required>
                                            <option value="email" selected>Email</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="d-block text-dark small fw-bold mb-2">Recipient Group</label>
                                        <select name="recipient_group" class="form-select" required>
                                            <option value="students" {{ old('recipient_group') === 'students' ? 'selected' : '' }}>Students</option>
                                            <option value="teachers" {{ old('recipient_group') === 'teachers' ? 'selected' : '' }}>Teachers</option>
                                            <option value="parents" {{ old('recipient_group') === 'parents' ? 'selected' : '' }}>Parents</option>
                                            <option value="all_users" {{ old('recipient_group') === 'all_users' ? 'selected' : '' }}>All Users</option>
                                            <option value="custom" {{ old('recipient_group') === 'custom' ? 'selected' : '' }}>Custom Emails</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="d-block text-dark small fw-bold mb-2">Custom Emails (comma/space separated)</label>
                                        <textarea name="custom_emails" class="form-control" rows="2" placeholder="user1@example.com, user2@example.com">{{ old('custom_emails') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="d-block text-dark small fw-bold mb-2">Subject</label>
                                        <input name="subject" value="{{ old('subject') }}" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="d-block text-dark small fw-bold mb-2">Message</label>
                                        <textarea name="message" class="form-control" rows="8" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                                    <a href="{{ route('communication.email-sms.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

