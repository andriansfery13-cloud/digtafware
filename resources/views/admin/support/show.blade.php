@extends('layouts.admin')

@section('header', 'Manage Support Ticket')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.support.index') }}"
            class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">&larr; Back to
            Tickets</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                <!-- Ticket Header -->
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
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
                                Ticket #{{ $ticket->id }} &bull; Created
                                {{ $ticket->created_at?->format('M d, Y H:i') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Conversation Thread -->
                <div class="p-6 space-y-8 bg-gray-50/50 dark:bg-gray-900/20">
                    <!-- User Message -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div
                                class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-bold text-sm">
                                {{ substr($ticket->user?->name ?? 'U', 0, 1) }}
                            </div>
                        </div>
                        <div
                            class="flex-1 bg-white dark:bg-gray-800 rounded-2xl rounded-tl-sm p-5 shadow-sm border border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-2">
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $ticket->user?->name ?? 'Unknown User' }}
                                    <span class="text-xs text-gray-500 font-normal">(Customer)</span></span>
                                <span
                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->created_at?->diffForHumans() ?? 'long ago' }}</span>
                            </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                                {{ $ticket->message }}
                            </div>
                        </div>
                    </div>

                    <!-- Admin Reply -->
                    @if($ticket->admin_reply)
                        <div class="flex gap-4 flex-row-reverse">
                            <div class="flex-shrink-0">
                                <div
                                    class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    A
                                </div>
                            </div>
                            <div
                                class="flex-1 bg-blue-50 dark:bg-blue-900/20 rounded-2xl rounded-tr-sm p-5 shadow-sm border border-blue-100 dark:border-blue-800/50">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-900 dark:text-white">Support Team <span
                                            class="text-xs text-blue-600 dark:text-blue-400 font-bold ml-1 px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/50 uppercase">Staff</span></span>
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->updated_at?->diffForHumans() ?? 'just now' }}</span>
                                </div>
                                <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">
                                    {{ $ticket->admin_reply }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Admin Response Area -->
                <div class="px-6 py-5 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Respond to Ticket</h4>
                    <form action="{{ route('admin.support.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <textarea name="admin_reply" rows="5" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md p-3"
                                placeholder="Type your reply to the customer here...">{{ $ticket->admin_reply }}</textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <label class="text-sm text-gray-600 dark:text-gray-400">Status:</label>
                                <select name="status"
                                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Keep Open</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Close Ticket
                                    </option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Save Changes & Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Customer Info</h4>
                <div class="flex items-center mb-4">
                    <div
                        class="h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold shadow-inner">
                        {{ substr($ticket->user?->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $ticket->user?->name ?? 'Unknown User' }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->user?->email ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    @if($ticket->user_id)
                        <a href="{{ route('admin.users.show', $ticket->user_id) }}"
                            class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">View User Profile
                            &rarr;</a>
                    @else
                        <span class="text-xs text-gray-500 italic">No user profile available</span>
                    @endif
                </div>
            </div>

            @if($ticket->order)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Order Details</h4>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-xs text-gray-500">Order ID:</span>
                            <span
                                class="text-xs font-bold text-gray-900 dark:text-white">#{{ $ticket->order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-gray-500">Status:</span>
                            <span
                                class="text-xs font-bold uppercase {{ $ticket->order->status == 'paid' ? 'text-green-600' : 'text-blue-600' }}">{{ $ticket->order->status }}</span>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.orders.show', $ticket->order_id) }}"
                            class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">View Order &rarr;</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection