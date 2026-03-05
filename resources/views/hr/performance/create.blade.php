<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Performance Review') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hr.performance.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Staff</label>
                            <select name="teacher_id" class="border rounded w-full py-2 px-3" required>
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Review Date</label>
                                <input type="date" name="review_date" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Score</label>
                                <input type="number" step="0.01" min="0" max="100" name="score" class="border rounded w-full py-2 px-3" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Remarks</label>
                            <textarea name="remarks" class="border rounded w-full py-2 px-3"></textarea>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
                            <a href="{{ route('hr.performance.index') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

