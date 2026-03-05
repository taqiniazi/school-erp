<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Staff Profile') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hr.staff.update', $profile) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Staff</label>
                            <select name="teacher_id" class="border rounded w-full py-2 px-3" required>
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}" {{ $profile->teacher_id === $t->id ? 'selected' : '' }}>{{ $t->first_name }} {{ $t->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Designation</label>
                                <input name="designation" value="{{ $profile->designation }}" class="border rounded w-full py-2 px-3" />
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Department</label>
                                <input name="department" value="{{ $profile->department }}" class="border rounded w-full py-2 px-3" />
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                                <input name="phone" value="{{ $profile->phone }}" class="border rounded w-full py-2 px-3" />
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Join Date</label>
                                <input type="date" name="join_date" value="{{ optional($profile->join_date)->format('Y-m-d') }}" class="border rounded w-full py-2 px-3" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                            <textarea name="address" class="border rounded w-full py-2 px-3">{{ $profile->address }}</textarea>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select name="status" class="border rounded w-full py-2 px-3" required>
                                <option value="active" {{ $profile->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $profile->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                            <a href="{{ route('hr.staff.index') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

