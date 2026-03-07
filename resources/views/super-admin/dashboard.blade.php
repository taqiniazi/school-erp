<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Super Admin Dashboard
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Schools</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalSchools }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Active {{ $activeSchools }} • Suspended {{ $suspendedSchools }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Admin Users</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $adminUsers }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Active Subscriptions</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $activeSubs }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">MRR</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">${{ number_format($mrr, 2) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Schools</h3>
                            <a href="{{ route('super-admin.schools.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Manage</a>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 dark:text-gray-400">
                                        <th class="py-2 pr-4">Name</th>
                                        <th class="py-2 pr-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 dark:text-gray-300">
                                    @forelse ($recentSchools as $s)
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <td class="py-2 pr-4">{{ $s->name }}</td>
                                            <td class="py-2 pr-4">
                                                <span class="px-2 py-1 rounded text-xs {{ $s->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                                    {{ $s->is_active ? 'Active' : 'Suspended' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="py-3" colspan="2">No schools</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Subscriptions</h3>
                            <a href="{{ route('super-admin.plans.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Plans</a>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 dark:text-gray-400">
                                        <th class="py-2 pr-4">School</th>
                                        <th class="py-2 pr-4">Plan</th>
                                        <th class="py-2 pr-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 dark:text-gray-300">
                                    @forelse ($subscriptions as $sub)
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <td class="py-2 pr-4">{{ optional($sub->school)->name }}</td>
                                            <td class="py-2 pr-4">{{ optional($sub->plan)->name }}</td>
                                            <td class="py-2 pr-4">{{ $sub->status }}</td>
                                        </tr>
                                    @empty
                                        <tr><td class="py-3" colspan="3">No subscriptions</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Active Plans</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse ($plans as $plan)
                            <div class="border border-gray-200 dark:border-gray-700 rounded p-4 dark:text-gray-300">
                                <div class="text-lg font-semibold">{{ $plan->name }}</div>
                                <div class="text-gray-600 dark:text-gray-400 text-sm mt-1 uppercase">{{ $plan->billing_cycle }}</div>
                                <div class="text-2xl font-bold mt-2">${{ number_format($plan->price, 2) }}</div>
                            </div>
                        @empty
                            <div class="text-gray-600 dark:text-gray-400">No active plans</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
