<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Events Calendar') }}
            </h2>
            @role('Super Admin|School Admin|Teacher')
            <a href="{{ route('communication.events.create') }}" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Add Event') }}
            </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">
                                {{ $event->start_date->format('M d, Y') }}
                            </span>
                            @if($event->location)
                            <span class="text-xs text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                {{ $event->location }}
                            </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                            {{ Str::limit($event->description, 100) }}
                        </p>
                        <div class="text-xs text-gray-500">
                            {{ $event->start_date->format('h:i A') }} 
                            @if($event->end_date)
                            - {{ $event->end_date->format('h:i A') }}
                            @endif
                        </div>
                        @role('Super Admin|School Admin')
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-2">
                            <a href="{{ route('communication.events.edit', $event) }}" class="text-blue-600 hover:text-blue-900 text-xs uppercase font-bold">Edit</a>
                            <form action="{{ route('communication.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs uppercase font-bold">Delete</button>
                            </form>
                        </div>
                        @endrole
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        No upcoming events found.
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
