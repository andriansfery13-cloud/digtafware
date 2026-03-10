@extends('layouts.dashboard')

@section('header', 'Ticket Details')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard.support.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
            Tickets</a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden max-w-4xl">

        <!-- Ticket Header -->
        <div
            class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h3>
                    @if($ticket->status == 'open')
                        <span
                            class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">Open</span>
                    @elseif($ticket->status == 'answered')
                        <span
                            class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">Answered</span>
                    @elseif($ticket->status == 'closed')
                        <span
                            class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Closed</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Ticket #{{ $ticket->id }} &bull; Created {{ $ticket->created_at->format('M d, Y H:i') }}
                    @if($ticket->order)
                        &bull; Order: <a href="{{ route('dashboard.orders.show', $ticket->order_id) }}"
                            class="text-indigo-600 hover:underline">#{{ $ticket->order->order_number }}</a>
                    @endif
                </p>
            </div>

            @if($ticket->status !== 'closed')
                <!-- In a real app you might have a close ticket button here -->
                <form action="#" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button"
                        class="text-sm font-medium text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 focus:outline-none bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 px-3 py-1.5 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Close Ticket (Demo)
                    </button>
                </form>
            @endif
        </div>

        <!-- Ticket Conversation Thread -->
        <div class="p-6 space-y-8 bg-gray-50/50 dark:bg-gray-900/20">

            <!-- Original Message (User) -->
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div
                        class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
                <div
                    class="flex-1 bg-white dark:bg-gray-800 rounded-2xl rounded-tl-sm p-5 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }} <span
                                class="text-xs text-gray-500 font-normal"> (You)</span></span>
                        <span
                            class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                        {{ $ticket->message }}</div>
                </div>
            </div>

            <!-- Admin Reply (If exists) -->
            @if($ticket->admin_reply)
                <div class="flex gap-4 flex-row-reverse">
                    <div class="flex-shrink-0">
                        <div
                            class="h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-700 dark:text-emerald-300 font-bold text-sm ring-2 ring-emerald-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="flex-1 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl rounded-tr-sm p-5 shadow-sm border border-emerald-100 dark:border-emerald-800/50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-900 dark:text-white">Support Team <span
                                    class="text-xs text-emerald-600 dark:text-emerald-400 font-bold ml-1 px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-900/50">Staff</span></span>
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">
                            {{ $ticket->admin_reply }}</div>
                    </div>
                </div>
            @else
                <div class="text-center py-6 text-sm text-gray-500 dark:text-gray-400 flex flex-col items-center">
                    <svg class="h-8 w-8 text-gray-300 dark:text-gray-600 mb-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Waiting for support team reply...
                </div>
            @endif

        </div>

        <!-- Reply Area (Disabled if closed or already answered ideally, but shown for demo) -->
        @if($ticket->status !== 'closed' && $ticket->admin_reply)
            <div class="px-6 py-5 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Add a Reply</h4>
                <form action="#" method="POST">
                    @csrf
                    <textarea rows="3"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md p-3"
                        placeholder="Type your message here..."></textarea>
                    <div class="mt-3 flex justify-end">
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Post Reply (Demo)
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection