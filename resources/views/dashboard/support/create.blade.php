@extends('layouts.dashboard')

@section('header', 'Open New Ticket')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard.support.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
            Tickets</a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden max-w-3xl">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Submit a Support Request</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Our support team will get back to you as soon as
                possible via email and this portal.</p>
        </div>

        <form action="{{ route('dashboard.support.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                    <div class="mt-1">
                        <input type="text" name="subject" id="subject" required value="{{ old('subject') }}"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                            placeholder="Brief summary of your issue">
                    </div>
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Related Order (Optional) -->
                <div>
                    <label for="order_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Related Order
                        (Optional)</label>
                    <div class="mt-1">
                        <select id="order_id" name="order_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">-- General Inquiry --</option>
                            @foreach(auth()->user()->orders()->orderBy('created_at', 'desc')->get() as $order)
                                <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                    #{{ $order->order_number }} - {{ $order->created_at->format('M d, Y') }} (Rp
                                    {{ number_format($order->total, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Select an order if your issue is related to a
                        specific purchase or download.</p>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detailed
                        Message</label>
                    <div class="mt-1">
                        <textarea id="message" name="message" rows="6" required
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                            placeholder="Please describe your issue in detail. Include error messages or steps to reproduce if applicable.">{{ old('message') }}</textarea>
                    </div>
                    @error('message')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-5 flex justify-end gap-3">
                <a href="{{ route('dashboard.support.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
@endsection