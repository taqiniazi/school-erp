<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name *</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name *</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth *</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob', $student->dob) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender *</label>
                                    <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>
                                    <input type="file" name="photo" id="photo" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                                    @if($student->photo_path)
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Current photo exists</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Academic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="admission_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Admission Number</label>
                                    <input type="text" name="admission_number" id="admission_number" value="{{ old('admission_number', $student->admission_number) }}" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                                <div>
                                    <label for="roll_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roll Number</label>
                                    <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number', $student->roll_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                                    <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                        <option value="left" {{ old('status', $student->status) == 'left' ? 'selected' : '' }}>Left</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="campus_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Campus</label>
                                    <select name="campus_id" id="campus_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Campus</option>
                                        @foreach($campuses as $campus)
                                            <option value="{{ $campus->id }}" {{ old('campus_id', $student->campus_id) == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="school_class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class *</label>
                                    <select name="school_class_id" id="school_class_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section *</label>
                                    <select name="section_id" id="section_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
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
                                    <textarea name="address" id="address" rows="2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">{{ old('address', $student->address) }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Update Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const classSelect = document.getElementById('school_class_id');
        const sectionSelect = document.getElementById('section_id');
        const initialClassId = "{{ $student->school_class_id }}";
        const oldSectionId = "{{ old('section_id', $student->section_id) }}";

        function loadSections(classId, selectedId = null) {
            sectionSelect.innerHTML = '<option value="">Loading...</option>';
            sectionSelect.disabled = true;
            
            fetch(`/classes/${classId}/sections`)
                .then(response => response.json())
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    data.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.name;
                        if (selectedId && section.id == selectedId) {
                            option.selected = true;
                        }
                        sectionSelect.appendChild(option);
                    });
                    sectionSelect.disabled = false;
                });
        }

        classSelect.addEventListener('change', function() {
            if (this.value) {
                loadSections(this.value);
            } else {
                sectionSelect.innerHTML = '<option value="">Select Class First</option>';
                sectionSelect.disabled = true;
            }
        });

        // Check if the current class (old or selected) is different from the initial class
        // If different, it means we have a validation error with a changed class, so we must reload sections
        // If same, the server-rendered sections are correct
        if (classSelect.value && classSelect.value != initialClassId) {
            loadSections(classSelect.value, oldSectionId);
        }
    </script>
</x-app-layout>