<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academic Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form method="GET" action="{{ route('reports.academic') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="school_class_id" :value="__('Class')" />
                            <select id="school_class_id" name="school_class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('school_class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="section_id" :value="__('Section')" />
                            <select id="section_id" name="section_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Filter') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @if($students->isNotEmpty())
                        <div class="mb-4 flex space-x-2">
                            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Export PDF
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Export Excel
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admission No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DOB</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->admission_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->schoolClass->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->section->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->roll_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($student->gender) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->dob }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-gray-500">
                            No students found. Please select a class to view report.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('school_class_id').addEventListener('change', function() {
            var classId = this.value;
            var sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (classId) {
                fetch(`/classes/${classId}/sections`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(section => {
                            var option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            if (section.id == "{{ request('section_id') }}") {
                                option.selected = true;
                            }
                            sectionSelect.appendChild(option);
                        });
                    });
            }
        });

        // Trigger change on load if value exists
        if (document.getElementById('school_class_id').value) {
            // Need to wait for fetch to complete before selecting section, or just rely on PHP rendering selected if possible?
            // The script above clears innerHTML, so PHP rendered options would be lost if I just trigger change.
            // Better to let the fetch happen.
             var classId = document.getElementById('school_class_id').value;
             var sectionSelect = document.getElementById('section_id');
             // sectionSelect.innerHTML = '<option value="">Select Section</option>'; // Don't clear if already populated by PHP? 
             // Actually, the view logic doesn't populate section options in PHP loop above (it's empty initially).
             // So I MUST trigger the fetch.
             
             fetch(`/classes/${classId}/sections`)
                .then(response => response.json())
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    data.forEach(section => {
                        var option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.name;
                        if (section.id == "{{ request('section_id') }}") {
                            option.selected = true;
                        }
                        sectionSelect.appendChild(option);
                    });
                });
        }
    </script>
</x-app-layout>