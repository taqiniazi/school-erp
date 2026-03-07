<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- My Classes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">My Classes</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalClasses ?? 0 }}</div>
                </div>

                <!-- My Students -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Total Students</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalStudents ?? 0 }}</div>
                </div>

                <!-- Present Today -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">Present Today</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $presentToday ?? 0 }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Upcoming Events & Notices -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Upcoming Events -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Upcoming Events</h3>
                            @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($upcomingEvents as $event)
                                        <li class="py-3">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $event->title }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y h:i A') }}</p>
                                                </div>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ $event->type ?? 'Event' }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">No upcoming events.</p>
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
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $notice->title }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $notice->created_at->diffForHumans() }}</p>
                                                </div>
                                                <a href="{{ route('communication.notices.show', $notice) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm">View</a>
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

                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-1 gap-3">
                                <a href="{{ route('attendance.create') }}" class="block px-4 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-100 transition dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50">
                                    + Take Attendance
                                </a>
                                <a href="{{ route('marks.create') }}" class="block px-4 py-2 bg-green-50 text-green-700 rounded hover:bg-green-100 transition dark:bg-green-900/30 dark:text-green-300 dark:hover:bg-green-900/50">
                                    + Enter Marks
                                </a>
                                <a href="{{ route('communication.messages.create') }}" class="block px-4 py-2 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-900/50">
                                    + Send Message
                                </a>
                                <a href="{{ route('teacher.my-attendance') }}" class="block px-4 py-2 bg-purple-50 text-purple-700 rounded hover:bg-purple-100 transition dark:bg-purple-900/30 dark:text-purple-300 dark:hover:bg-purple-900/50">
                                    View My Attendance
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
