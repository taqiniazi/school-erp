<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Plans
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('super-admin.plans.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">New Plan</a>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500">
                                    <th class="py-2 pr-4">Name</th>
                                    <th class="py-2 pr-4">Code</th>
                                    <th class="py-2 pr-4">Price</th>
                                    <th class="py-2 pr-4">Cycle</th>
                                    <th class="py-2 pr-4">Active</th>
                                    <th class="py-2 pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($plans as $plan)
                                <tr class="border-t">
                                    <td class="py-2 pr-4">{{ $plan->name }}</td>
                                    <td class="py-2 pr-4">{{ $plan->code }}</td>
                                    <td class="py-2 pr-4">${{ number_format($plan->price, 2) }}</td>
                                    <td class="py-2 pr-4">{{ $plan->billing_cycle }}</td>
                                    <td class="py-2 pr-4">{{ $plan->is_active ? 'Yes' : 'No' }}</td>
                                    <td class="py-2 pr-4">
                                        <a href="{{ route('super-admin.plans.edit', $plan) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('super-admin.plans.destroy', $plan) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Delete this plan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $plans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
