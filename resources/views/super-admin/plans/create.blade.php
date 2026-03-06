<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Plan
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <form method="POST" action="{{ route('super-admin.plans.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-700">Name</label>
                            <input name="name" class="mt-1 w-full border rounded p-2" required />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Code</label>
                            <input name="code" class="mt-1 w-full border rounded p-2" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700">Price</label>
                                <input name="price" type="number" step="0.01" min="0" class="mt-1 w-full border rounded p-2" required />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">Billing Cycle</label>
                                <select name="billing_cycle" class="mt-1 w-full border rounded p-2">
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Features (JSON)</label>
                            <textarea name="features" class="mt-1 w-full border rounded p-2" rows="4" placeholder='{"students_limit":1000}'></textarea>
                        </div>
                        <div class="flex items-center">
                            <input id="is_active" type="checkbox" name="is_active" class="mr-2" checked />
                            <label for="is_active" class="text-sm text-gray-700">Active</label>
                        </div>
                        <div class="pt-2">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create</button>
                            <a href="{{ route('super-admin.plans.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
