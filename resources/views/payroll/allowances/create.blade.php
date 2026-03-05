<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Allowance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('payroll.allowances.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Staff</label>
                                <select name="teacher_id" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                                <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                            </div>
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_percentage" id="is_percentage" class="mr-2">
                                <label for="is_percentage" class="text-gray-700 text-sm font-bold">Percentage</label>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Amount / %</label>
                                <input type="number" step="0.01" name="amount" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save
                            </button>
                            <a href="{{ route('payroll.allowances.index') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

