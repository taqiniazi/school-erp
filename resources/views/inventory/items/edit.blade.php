<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Inventory Item') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('inventory.items.update', $item) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                                <input name="name" value="{{ $item->name }}" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
                                <input name="sku" value="{{ $item->sku }}" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Unit</label>
                                <input name="unit" value="{{ $item->unit }}" class="border rounded w-full py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Reorder Level</label>
                                <input type="number" name="reorder_level" min="0" value="{{ $item->reorder_level }}" class="border rounded w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                <select name="status" class="border rounded w-full py-2 px-3" required>
                                    <option value="active" {{ $item->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $item->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                            <a href="{{ route('inventory.items.index') }}" class="text-blue-600 hover:text-blue-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

