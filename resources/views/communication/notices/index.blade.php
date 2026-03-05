<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notices Board') }}
            </h2>
            @role('Super Admin|School Admin|Teacher')
            <a href="{{ route('communication.notices.create') }}" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Post New Notice') }}
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

            <div class="grid grid-cols-1 gap-4">
                @forelse($notices as $notice)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold">
                                    @if($notice->type == 'urgent')
                                    <span class="text-red-600">[URGENT]</span>
                                    @elseif($notice->type == 'event')
                                    <span class="text-blue-600">[EVENT]</span>
                                    @endif
                                    {{ $notice->title }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Posted by {{ $notice->creator->name ?? 'Unknown' }} 
                                    to {{ ucfirst($notice->audience_role) }} 
                                    on {{ $notice->published_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                            @role('Super Admin|School Admin')
                            <div class="flex space-x-2">
                                <a href="{{ route('communication.notices.edit', $notice) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                                <form action="{{ route('communication.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                </form>
                            </div>
                            @endrole
                        </div>
                        <div class="mt-4 prose dark:prose-invert max-w-none">
                            {!! nl2br(e($notice->content)) !!}
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        No notices found.
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $notices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
