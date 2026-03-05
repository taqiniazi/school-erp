<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form method="GET" action="{{ route('reports.attendance') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
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
                            <select id="section_id" name="section_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="month" :value="__('Month')" />
                            <select id="month" name="month" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <x-input-label for="year" :value="__('Year')" />
                            <select id="year" name="year" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="flex items-end">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Filter') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @if($attendances->isNotEmpty())
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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Late</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($attendances as $record)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record['student']->admission_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $record['student']->first_name }} {{ $record['student']->last_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $record['present'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">{{ $record['absent'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">{{ $record['late'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $record['percentage'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-gray-500">
                            No attendance records found for the selected criteria.
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

        if (document.getElementById('school_class_id').value) {
            var classId = document.getElementById('school_class_id').value;
            var sectionSelect = document.getElementById('section_id');
            
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