<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Welcome, ') . Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Quick Navigation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @role('Super Admin|School Admin')
                        <a href="{{ route('admin.dashboard') }}" class="block p-6 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-800 text-indigo-600 dark:text-indigo-300 mr-4">
                                    <i class="fas fa-tachometer-alt fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Admin Dashboard</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Manage school operations</div>
                                </div>
                            </div>
                        </a>
                        @endrole

                        @role('Teacher')
                        <a href="{{ route('teacher.dashboard') }}" class="block p-6 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-300 mr-4">
                                    <i class="fas fa-chalkboard-teacher fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Teacher Dashboard</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">View classes and students</div>
                                </div>
                            </div>
                        </a>
                        @endrole

                        @role('Student')
                        <a href="{{ route('student.dashboard') }}" class="block p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-300 mr-4">
                                    <i class="fas fa-user-graduate fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Student Portal</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Check grades and attendance</div>
                                </div>
                            </div>
                        </a>
                        @endrole

                        @role('Parent')
                        <a href="{{ route('parent.dashboard') }}" class="block p-6 bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-800 text-purple-600 dark:text-purple-300 mr-4">
                                    <i class="fas fa-user-friends fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Parent Portal</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Monitor children's progress</div>
                                </div>
                            </div>
                        </a>
                        @endrole
                        
                        <a href="{{ route('profile.edit') }}" class="block p-6 bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700 rounded-lg hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 mr-4">
                                    <i class="fas fa-user-cog fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Profile Settings</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Update account details</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
