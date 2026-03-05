<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Financial Year') }} - {{ $financialYear->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('financial-years.update', $financialYear) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                                <input type="text" name="name" id="name" value="{{ $financialYear->name }}" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                            </div>
                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $financialYear->start_date }}" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                            </div>
                            <div class="mb-4">
                                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $financialYear->end_date }}" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                            </div>
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_current" id="is_current" class="mr-2" {{ $financialYear->is_current ? 'checked' : '' }}>
                                <label for="is_current" class="text-gray-700 text-sm font-bold">Set as current</label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                            <a href="{{ route('financial-years.index') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

