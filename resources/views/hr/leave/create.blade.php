<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Leave Request') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hr.leave.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                                <input type="date" name="start_date" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                                <input type="date" name="end_date" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                                <select name="type" class="border rounded w-full py-2 px-3" required>
                                    <option value="sick">Sick</option>
                                    <option value="casual">Casual</option>
                                    <option value="annual">Annual</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Reason</label>
                                <textarea name="reason" class="border rounded w-full py-2 px-3"></textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Submit</button>
                            <a href="{{ route('hr.leave.my') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

