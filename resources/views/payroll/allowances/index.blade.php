<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allowances') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <form method="GET" class="flex items-end space-x-2">
                            <div>
                                <label class="block text-sm text-gray-700">Staff</label>
                                <select name="teacher_id" class="border rounded px-2 py-1">
                                    <option value="">All</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ ($teacherId == $t->id) ? 'selected' : '' }}>{{ $t->first_name }} {{ $t->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="px-3 py-2 bg-gray-200 rounded">Filter</button>
                        </form>
                        <a href="{{ route('payroll.allowances.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">New</a>
                    </div>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($allowances as $a)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $a->teacher->first_name }} {{ $a->teacher->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $a->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $a->is_percentage ? $a->amount.'%' : number_format($a->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $a->is_active ? 'Yes' : 'No' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('payroll.allowances.edit', $a) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                            <form action="{{ route('payroll.allowances.destroy', $a) }}" method="POST" class="inline" onsubmit="return confirm('Delete this allowance?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

