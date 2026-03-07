<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parent Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- My Children -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">My Children</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $childrenCount }}</div>
                </div>

                <!-- Outstanding Fees -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Outstanding Fees</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">${{ number_format($outstandingFees, 2) }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('student.invoices') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition dark:bg-purple-500 dark:hover:bg-purple-600">
                            Pay Fees
                        </a>
                        <a href="{{ route('communication.messages.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            Message Teacher
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- My Children List -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">My Children</h3>
                        @if($childrenCount > 0)
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($children as $child)
                                    <li class="py-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $child->first_name }} {{ $child->last_name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Class: {{ $child->class->name ?? 'N/A' }} - {{ $child->section->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('student.report_card', ['student_id' => $child->id]) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 text-xs">Report Card</a>
                                                <a href="{{ route('student.my-attendance', ['student_id' => $child->id]) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-xs">Attendance</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">No children linked.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Notices -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Notices</h3>
                        @if(isset($recentNotices) && $recentNotices->count() > 0)
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentNotices as $notice)
                                    <li class="py-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate" style="max-width: 150px;">{{ $notice->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notice->created_at->diffForHumans() }}</p>
                                            </div>
                                            <a href="{{ route('communication.notices.show', $notice) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs">View</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">No new notices.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
