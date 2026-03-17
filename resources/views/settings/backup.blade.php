<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm mb-0">
            Backup
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

            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1">School Backup</h5>
                        <div class="text-secondary small">Creates a JSON export of school profile and settings.</div>
                    </div>
                    <form method="POST" action="{{ route('settings.backup.create') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Create Backup</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h5 class="mb-3">Backups</h5>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th class="text-end">Size</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($backups as $backup)
                                    <tr>
                                        <td class="text-nowrap">{{ $backup['file'] }}</td>
                                        <td class="text-end text-nowrap">{{ number_format(((int) $backup['size']) / 1024, 2) }} KB</td>
                                        <td class="text-nowrap">{{ \Carbon\Carbon::createFromTimestamp($backup['last_modified'])->toDayDateTimeString() }}</td>
                                        <td class="text-end text-nowrap">
                                            <a href="{{ route('settings.backup.download', ['backupFile' => $backup['file']]) }}" class="btn btn-sm btn-outline-primary">Download</a>
                                            <form method="POST" action="{{ route('settings.backup.delete', ['backupFile' => $backup['file']]) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this backup file?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-secondary py-4">No backups found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
