<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Schools
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500">
                                    <th class="py-2 pr-4">Name</th>
                                    <th class="py-2 pr-4">Students</th>
                                    <th class="py-2 pr-4">Staff</th>
                                    <th class="py-2 pr-4">Campuses</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 pr-4">Subscription</th>
                                    <th class="py-2 pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($schools as $s)
                                    @php
                                        $sub = $s->subscriptions->first();
                                    @endphp
                                    <tr class="border-t">
                                        <td class="py-2 pr-4">{{ $s->name }}</td>
                                        <td class="py-2 pr-4">{{ $s->students_count }}</td>
                                        <td class="py-2 pr-4">{{ $s->teachers_count }}</td>
                                        <td class="py-2 pr-4">{{ $s->campuses_count }}</td>
                                        <td class="py-2 pr-4">
                                            <span class="px-2 py-1 rounded text-xs {{ $s->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $s->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="py-2 pr-4">
                                            {{ optional(optional($sub)->plan)->name ?: '—' }} {{ $sub ? '(' . $sub->status . ')' : '' }}
                                        </td>
                                        <td class="py-2 pr-4">
                                            @if(!$s->is_active)
                                            <form action="{{ route('super-admin.schools.activate', $s) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Activate</button>
                                            </form>
                                            @else
                                            <form action="{{ route('super-admin.schools.deactivate', $s) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800">Deactivate</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $schools->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
