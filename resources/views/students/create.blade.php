<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name *</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name *</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth *</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender *</label>
                                    <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>
                                    <input type="file" name="photo" id="photo" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Academic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="admission_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Admission Number *</label>
                                    <input type="text" name="admission_number" id="admission_number" value="{{ old('admission_number') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="admission_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Admission Date *</label>
                                    <input type="date" name="admission_date" id="admission_date" value="{{ old('admission_date') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="roll_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roll Number</label>
                                    <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="campus_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Campus</label>
                                    <select name="campus_id" id="campus_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Campus</option>
                                        @foreach($campuses as $campus)
                                            <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="school_class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class *</label>
                                    <select name="school_class_id" id="school_class_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section *</label>
                                    <select name="section_id" id="section_id" required disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed">
                                        <option value="">Select Class First</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Contact Information</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address *</label>
                                    <textarea name="address" id="address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('students.index') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                Save Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
