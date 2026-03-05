<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Attendance % -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Attendance</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $attendancePercentage }}%</div>
                </div>

                <!-- Unpaid Invoices -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Unpaid Invoices</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $unpaidInvoices }}</div>
                </div>

                <!-- Average Marks -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Average Marks</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $averageMarks }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('student.my-attendance') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            View My Attendance
                        </a>
                        <a href="{{ route('student.report_card') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            View Report Card
                        </a>
                        <a href="{{ route('student.invoices') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                            My Invoices
                        </a>
                        <a href="{{ route('library.my') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            My Library
                        </a>
                        <a href="{{ route('communication.messages.create') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                            Message Teacher
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Upcoming Exams -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Exams</h3>
                        @if(isset($upcomingExams) && $upcomingExams->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($upcomingExams as $exam)
                                    <li class="py-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $exam->subject->name ?? 'Subject' }}</p>
                                                <p class="text-xs text-gray-500">{{ $exam->exam->name ?? 'Exam' }}</p>
                                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic">No upcoming exams.</p>
                        @endif
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Events</h3>
                        @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($upcomingEvents as $event)
                                    <li class="py-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $event->title }}</p>
                                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic">No upcoming events.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Notices -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Notices</h3>
                        @if(isset($recentNotices) && $recentNotices->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentNotices as $notice)
                                    <li class="py-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 truncate" style="max-width: 150px;">{{ $notice->title }}</p>
                                                <p class="text-xs text-gray-500">{{ $notice->created_at->diffForHumans() }}</p>
                                            </div>
                                            <a href="{{ route('communication.notices.show', $notice) }}" class="text-indigo-600 hover:text-indigo-900 text-xs">View</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic">No new notices.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
