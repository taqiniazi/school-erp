<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Issue') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('inventory.issues.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Item</label>
                                <select name="inventory_item_id" class="border rounded w-full py-2 px-3" required>
                                    @foreach($items as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }} (Stock: {{ $i->current_stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                                <input type="number" name="quantity" min="1" value="1" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Issue Date</label>
                                <input type="date" name="issue_date" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Recipient</label>
                                <input name="recipient" class="border rounded w-full py-2 px-3">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Remarks</label>
                                <textarea name="remarks" class="border rounded w-full py-2 px-3"></textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
                            <a href="{{ route('inventory.issues.index') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

