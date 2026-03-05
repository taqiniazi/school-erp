<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('communication.events.update', $event) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Event Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$event->title" required autofocus />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ $event->description }}</textarea>
                        </div>

                        <!-- Start Date/Time -->
                        <div class="mt-4">
                            <x-input-label for="start_date" :value="__('Start Date & Time')" />
                            <x-text-input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date" :value="$event->start_date->format('Y-m-d\TH:i')" required />
                        </div>

                        <!-- End Date/Time -->
                        <div class="mt-4">
                            <x-input-label for="end_date" :value="__('End Date & Time')" />
                            <x-text-input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date" :value="$event->end_date ? $event->end_date->format('Y-m-d\TH:i') : ''" />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="$event->location" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update Event') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
