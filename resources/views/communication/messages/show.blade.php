<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $message->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <div class="flex justify-between">
                            <div>
                                <span class="font-bold">From:</span> {{ $message->sender->name }}
                                <br>
                                <span class="font-bold">To:</span> {{ $message->recipient->name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $message->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                    <div class="prose dark:prose-invert max-w-none mb-6">
                        {!! nl2br(e($message->content)) !!}
                    </div>

                    <div class="flex space-x-4">
                        <a href="{{ route('communication.messages.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Back to Inbox</a>
                        @if($message->recipient_id == auth()->id())
                        <a href="{{ route('communication.messages.create') }}?recipient_id={{ $message->sender_id }}&subject=Re: {{ urlencode($message->subject) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Reply</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
