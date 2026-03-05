<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit Log Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('admin.audit-logs.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Logs</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Event Information</h3>
                            <dl class="mt-2 text-sm text-gray-600">
                                <div class="flex justify-between py-1 border-b">
                                    <dt>User:</dt>
                                    <dd>{{ $auditLog->user->name ?? 'System' }} (ID: {{ $auditLog->user_id }})</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b">
                                    <dt>Event:</dt>
                                    <dd>{{ ucfirst($auditLog->event) }}</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b">
                                    <dt>Model:</dt>
                                    <dd>{{ $auditLog->auditable_type }} (ID: {{ $auditLog->auditable_id }})</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b">
                                    <dt>IP Address:</dt>
                                    <dd>{{ $auditLog->ip_address }}</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b">
                                    <dt>URL:</dt>
                                    <dd>{{ $auditLog->url }}</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b">
                                    <dt>User Agent:</dt>
                                    <dd>{{ $auditLog->user_agent }}</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b">
                                    <dt>Time:</dt>
                                    <dd>{{ $auditLog->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Changes</h3>
                            <div class="mt-2">
                                <h4 class="text-sm font-medium text-gray-700">Old Values:</h4>
                                <pre class="bg-gray-100 p-2 rounded text-xs overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700">New Values:</h4>
                                <pre class="bg-gray-100 p-2 rounded text-xs overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>