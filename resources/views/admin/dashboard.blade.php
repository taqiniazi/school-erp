<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Total Students</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</div>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Total Teachers</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalTeachers }}</div>
                </div>

                <!-- Total Classes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Total Classes</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalClasses }}</div>
                </div>

                <!-- Monthly Fees -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm uppercase font-semibold">Monthly Fees</div>
                    <div class="text-3xl font-bold text-gray-800">${{ number_format($monthlyFeeCollection, 2) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Alerts & Notifications -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Alerts & Notifications</h3>
                            
                            @if($lowStockItems > 0)
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">
                                                <span class="font-bold">{{ $lowStockItems }}</span> inventory items are running low on stock.
                                                <a href="{{ route('inventory.alerts.low_stock') }}" class="font-bold underline hover:text-red-600">View Items</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($pendingLeaveRequests > 0)
                                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                <span class="font-bold">{{ $pendingLeaveRequests }}</span> pending leave requests need approval.
                                                <a href="{{ route('hr.leave.index') }}" class="font-bold underline hover:text-yellow-600">Review Requests</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($lowStockItems == 0 && $pendingLeaveRequests == 0)
                                <p class="text-gray-500 italic">No active alerts at this time.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-1 gap-3">
                                <a href="{{ route('students.create') }}" class="block px-4 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-100 transition">
                                    + Add New Student
                                </a>
                                <a href="{{ route('teachers.create') }}" class="block px-4 py-2 bg-green-50 text-green-700 rounded hover:bg-green-100 transition">
                                    + Add New Teacher
                                </a>
                                <a href="{{ route('communication.notices.create') }}" class="block px-4 py-2 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition">
                                    + Create Notice
                                </a>
                                <a href="{{ route('fee-invoices.create') }}" class="block px-4 py-2 bg-purple-50 text-purple-700 rounded hover:bg-purple-100 transition">
                                    + Generate Invoice
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Links -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Reports</h3>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li><a href="{{ route('attendance.report') }}" class="hover:text-blue-600 hover:underline">Attendance Report</a></li>
                                <li><a href="{{ route('fee-payments.history') }}" class="hover:text-blue-600 hover:underline">Fee Collection Report</a></li>
                                <li><a href="{{ route('inventory.items.index') }}" class="hover:text-blue-600 hover:underline">Inventory Report</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
