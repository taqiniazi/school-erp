<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">
            Email Settings
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Mailer Configuration</h5>

                            <form method="POST" action="{{ route('settings.email.update') }}">
                                @csrf

                                @php($mailer = old('mailer', $emailSettings['mailer'] ?? 'smtp'))
                                <div class="mb-3">
                                    <label class="form-label">Mailer</label>
                                    <select name="mailer" class="form-select" required>
                                        <option value="smtp" {{ $mailer === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                        <option value="sendmail" {{ $mailer === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                        <option value="log" {{ $mailer === 'log' ? 'selected' : '' }}>Log</option>
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Host</label>
                                        <input type="text" name="host" class="form-control" value="{{ old('host', $emailSettings['host'] ?? null) }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Port</label>
                                        <input type="number" name="port" class="form-control" value="{{ old('port', $emailSettings['port'] ?? null) }}">
                                    </div>

                                    @php($encryption = old('encryption', $emailSettings['encryption'] ?? null))
                                    <div class="col-md-3">
                                        <label class="form-label">Encryption</label>
                                        <select name="encryption" class="form-select">
                                            <option value="" {{ empty($encryption) ? 'selected' : '' }}>None</option>
                                            <option value="tls" {{ $encryption === 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ $encryption === 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ old('username', $emailSettings['username'] ?? null) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" value="" placeholder="Leave blank to keep current password">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">From Address</label>
                                        <input type="email" name="from_address" class="form-control" value="{{ old('from_address', $emailSettings['from_address'] ?? null) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">From Name</label>
                                        <input type="text" name="from_name" class="form-control" value="{{ old('from_name', $emailSettings['from_name'] ?? null) }}">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Save Settings</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Send Test Email</h5>

                            <form method="POST" action="{{ route('settings.email.test') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">To Email</label>
                                    <input type="email" name="to_email" class="form-control" value="{{ old('to_email') }}" required>
                                </div>

                                <button type="submit" class="btn btn-outline-primary">Send Test Email</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
