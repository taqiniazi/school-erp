<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col items-center text-center">
                            @if($student->photo_path)
                                <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Student Photo" class="w-32 h-32 rounded-full object-cover mb-4 border-4 border-gray-200 dark:border-gray-700">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mb-4 text-4xl text-white font-bold">
                                    {{ substr($student->first_name, 0, 1) }}
                                </div>
                            @endif
                            
                            <h3 class="text-xl font-bold mb-1">{{ $student->first_name }} {{ $student->last_name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $student->admission_number }}</p>
                            
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $student->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                  ($student->status === 'graduated' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                  'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-center mb-6 border-b pb-4 dark:border-gray-700">
                                <h3 class="text-lg font-medium">Student Information</h3>
                                <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Edit
                                </a>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="font-medium text-gray-500 dark:text-gray-400">Date of Birth:</div>
                                    <div class="sm:col-span-2">{{ $student->dob }}</div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="font-medium text-gray-500 dark:text-gray-400">Gender:</div>
                                    <div class="sm:col-span-2">{{ ucfirst($student->gender) }}</div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="font-medium text-gray-500 dark:text-gray-400">Class & Section:</div>
                                    <div class="sm:col-span-2">
                                        {{ $student->schoolClass->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="font-medium text-gray-500 dark:text-gray-400">Admission Date:</div>
                                    <div class="sm:col-span-2">{{ $student->admission_date }}</div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="font-medium text-gray-500 dark:text-gray-400">Address:</div>
                                    <div class="sm:col-span-2">{{ $student->address }}</div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t pt-4 dark:border-gray-700">
                                    <div class="font-medium text-gray-500 dark:text-gray-400">Parents/Guardians:</div>
                                    <div class="sm:col-span-2">
                                        @if($student->parents && $student->parents->count() > 0)
                                            @foreach($student->parents as $parent)
                                                <div class="mb-2 last:mb-0">
                                                    <span class="font-semibold">{{ $parent->user->name }}</span> 
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">({{ $parent->pivot->relation }})</span>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $parent->user->email }}</div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 italic">No parents linked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>