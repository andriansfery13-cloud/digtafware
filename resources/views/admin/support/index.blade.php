@extends('layouts.admin')

@section('header', 'Support Tickets Management')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Support Tickets</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage customer support requests and inquiries.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            User</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Ticket Details</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Related Order</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Last Updated</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-xs uppercase shadow-sm">
                                        {{ substr($ticket->user?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $ticket->user?->name ?? 'Unknown User' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->user?->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                                        {{ $ticket->subject }}
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 max-w-xs">
                                        {{ $ticket->message }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ticket->order)
                                    <a href="{{ route('admin.orders.show', $ticket->order_id) }}"
                                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        #{{ $ticket->order->order_number }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400 italic">General Inquiry</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $ticket->updated_at?->diffForHumans() ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ticket->status == 'open')
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">
                                        Open
                                    </span>
                                @elseif($ticket->status == 'answered')
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">
                                        Answered
                                    </span>
                                @elseif($ticket->status == 'closed')
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Closed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.support.show', $ticket->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="block font-medium">No tickets found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($tickets) && $tickets->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
@endsection
