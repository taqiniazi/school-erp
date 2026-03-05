<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave Requests') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($requests as $r)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $r->teacher->first_name }} {{ $r->teacher->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $r->start_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $r->end_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($r->type) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($r->status) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            @if($r->status === 'pending')
                                                <form action="{{ route('hr.leave.approve', $r) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="text-green-600 hover:text-green-800 mr-3">Approve</button>
                                                </form>
                                                <form action="{{ route('hr.leave.reject', $r) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="text-red-600 hover:text-red-800">Reject</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-4">No leave requests</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

