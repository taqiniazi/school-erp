<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Fee Structure') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('fee-structures.update', $feeStructure->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="school_class_id" class="block text-gray-700 text-sm font-bold mb-2">Class:</label>
                                <select name="school_class_id" id="school_class_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $feeStructure->school_class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="fee_type_id" class="block text-gray-700 text-sm font-bold mb-2">Fee Type:</label>
                                <select name="fee_type_id" id="fee_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    @foreach($feeTypes as $type)
                                        <option value="{{ $type->id }}" {{ $feeStructure->fee_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
                                <input type="number" step="0.01" name="amount" id="amount" value="{{ $feeStructure->amount }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div class="mb-4">
                                <label for="frequency" class="block text-gray-700 text-sm font-bold mb-2">Frequency:</label>
                                <select name="frequency" id="frequency" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="1" {{ $feeStructure->frequency == 1 ? 'selected' : '' }}>Monthly</option>
                                    <option value="2" {{ $feeStructure->frequency == 2 ? 'selected' : '' }}>Quarterly</option>
                                    <option value="3" {{ $feeStructure->frequency == 3 ? 'selected' : '' }}>Annually</option>
                                    <option value="0" {{ $feeStructure->frequency == 0 ? 'selected' : '' }}>One-time</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="academic_year" class="block text-gray-700 text-sm font-bold mb-2">Academic Year:</label>
                                <input type="text" name="academic_year" id="academic_year" value="{{ $feeStructure->academic_year }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="mb-4">
                                <div class="font-medium text-red-600">
                                    {{ __('Whoops! Something went wrong.') }}
                                </div>
                                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Fee Structure
                            </button>
                            <a href="{{ route('fee-structures.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
