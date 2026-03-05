<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library Loans') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('library.loans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Issue Book</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Borrower</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issued</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Returned</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Fine</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($loans as $loan)
                                    <tr>
                                        <td class="px-6 py-4">{{ optional($loan->book)->title }}</td>
                                        <td class="px-6 py-4">{{ optional($loan->user)->name }}</td>
                                        <td class="px-6 py-4">{{ $loan->issued_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4">{{ $loan->due_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4">{{ $loan->returned_at ? $loan->returned_at->format('Y-m-d H:i') : '-' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            @if($loan->status==='issued')
                                                {{ number_format($loan->currentAccruedFine(), 2) }}
                                            @else
                                                {{ number_format($loan->fine_amount, 2) }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ ucfirst($loan->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            @if($loan->status==='issued')
                                                <form action="{{ route('library.loans.return', $loan) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="text-blue-600" onclick="return confirm('Mark as returned?')">Return</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $loans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

