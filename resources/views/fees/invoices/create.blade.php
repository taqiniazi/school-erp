<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Invoices (Bulk)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('fee-invoices.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="school_class_id" class="block text-gray-700 text-sm font-bold mb-2">Class:</label>
                                <select name="school_class_id" id="school_class_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="student_id" class="block text-gray-700 text-sm font-bold mb-2">Student (Optional):</label>
                                <select name="student_id" id="student_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">All Students</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Leave blank to generate for all students in the selected class.</p>
                            </div>
                            <div class="mb-4">
                                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Fee Type:</label>
                                <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="monthly">Monthly Fees</option>
                                    <option value="annual">Annual Fees</option>
                                    <option value="one_time">One-time Fees</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="issue_date" class="block text-gray-700 text-sm font-bold mb-2">Issue Date:</label>
                                <input type="date" name="issue_date" id="issue_date" value="{{ date('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div class="mb-4">
                                <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date:</label>
                                <input type="date" name="due_date" id="due_date" value="{{ date('Y-m-d', strtotime('+10 days')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                        </div>

                        @if(session('error'))
                            <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="return confirm('This will generate invoices for all active students in the selected class. Are you sure?')">
                                Generate Invoices
                            </button>
                            <a href="{{ route('fee-invoices.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('school_class_id').addEventListener('change', function() {
            var classId = this.value;
            var studentSelect = document.getElementById('student_id');
            
            // Clear current options
            studentSelect.innerHTML = '<option value="">All Students</option>';
            
            if (classId) {
                // Fetch students for the selected class
                fetch(`/classes/${classId}/students`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(student => {
                            var option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = `${student.first_name} ${student.last_name} (${student.admission_number})`;
                            studentSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching students:', error));
            }
        });
    </script>
</x-app-layout>
