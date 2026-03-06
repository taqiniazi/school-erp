<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Admin Users
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Admin Users</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500">
                                        <th class="py-2 pr-4">Name</th>
                                        <th class="py-2 pr-4">Email</th>
                                        <th class="py-2 pr-4">School</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @foreach ($admins as $u)
                                    <tr class="border-t">
                                        <td class="py-2 pr-4">{{ $u->name }}</td>
                                        <td class="py-2 pr-4">{{ $u->email }}</td>
                                        <td class="py-2 pr-4">{{ optional($u->school)->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Create Admin User</h3>
                        <form method="POST" action="{{ route('super-admin.admin-users.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm text-gray-700">Name</label>
                                <input name="name" class="mt-1 w-full border rounded p-2" required />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">Email</label>
                                <input name="email" type="email" class="mt-1 w-full border rounded p-2" required />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">Password</label>
                                <input name="password" type="password" class="mt-1 w-full border rounded p-2" required />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">School</label>
                                <select name="school_id" class="mt-1 w-full border rounded p-2" required>
                                    @foreach ($schools as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-2">
                                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
