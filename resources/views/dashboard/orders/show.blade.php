@extends('layouts.dashboard')

@section('header', 'Order Details')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('dashboard.orders') }}"
                class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 mb-2 inline-block">&larr;
                Back to Orders</a>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                Order #{{ $order->order_number }}
                @if($order->status == 'paid')
                    <span
                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">Paid</span>
                @elseif($order->status == 'pending')
                    <span
                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400">Pending
                        Payment</span>
                @elseif($order->status == 'verifying')
                    <span
                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">Verifying</span>
                @elseif($order->status == 'cancelled')
                    <span
                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400">Cancelled</span>
                @else
                    <span
                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ ucfirst($order->status) }}</span>
                @endif
            </h2>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">Placed on
                    {{ $order->created_at->format('M d, Y, H:i A') }}
                </p>
                @if($order->status === 'pending' && $expiresAt)
                    <div
                        class="flex items-center gap-1.5 text-sm font-medium text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 px-2 py-0.5 rounded-md border border-orange-100 dark:border-orange-800/30">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Payment expires in: <span id="payment-countdown"
                                data-expire="{{ $expiresAt->timestamp }}">--:--:--</span></span>
                    </div>
                @endif
            </div>
        </div>

        @if($order->status == 'paid')
            <div class="flex gap-3">
                <a href="{{ route('dashboard.invoices.show', $order->id) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="h-4 w-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download Invoice
                </a>
                <a href="{{ route('dashboard.downloads') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Go to Downloads
                </a>
            </div>
        @elseif($order->status == 'pending')
            <form action="{{ route('dashboard.orders.repay', $order->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Pay Now
                </button>
            </form>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Items -->
        <div class="lg:col-span-2 space-y-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Order Items</h3>
                </div>

                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        <li class="p-4 sm:p-6 flex items-start sm:items-center flex-col sm:flex-row gap-4 sm:gap-6">
                            <div
                                class="flex-shrink-0 w-full sm:w-24 h-48 sm:h-24 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($item->product->thumbnail)
                                    <img src="{{ Storage::url($item->product->thumbnail) }}" alt="{{ $item->product->title }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 flex flex-col sm:flex-row justify-between w-full h-full">
                                <div class="mb-4 sm:mb-0">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white mb-1"><a
                                            href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->title }}</a>
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        {{ $item->product->category->name }}
                                    </p>

                                    @if($order->status == 'paid')
                                        @php
                                            // Find download or license for this item if needed to show here
                                        @endphp
                                        <div class="flex gap-3 text-sm">
                                            <a href="{{ route('dashboard.downloads') }}"
                                                class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 flex items-center gap-1 font-medium">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Get Files
                                            </a>
                                            <a href="{{ route('products.show', $item->product->slug) }}"
                                                class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white flex items-center gap-1">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                                Write Review
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="sm:text-right font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Right Column: Summary & Payment -->
        <div class="lg:col-span-1 space-y-8">

            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Order Summary</h3>
                </div>
                <div class="p-4 sm:p-6 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex justify-between py-2">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-900 dark:text-white">Rp
                            {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <!-- If discount logic added later, show here -->
                    <div
                        class="flex justify-between py-2 border-t border-gray-200 dark:border-gray-700 mt-2 font-bold text-gray-900 dark:text-white text-base">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Payment Info</h3>
                </div>
                <div class="p-4 sm:p-6 text-sm text-gray-600 dark:text-gray-400">
                    @if($order->payment)
                        <div class="mb-4">
                            <p class="font-medium text-gray-900 dark:text-white mb-1">Payment Method</p>
                            <p class="capitalize">{{ str_replace('_', ' ', $order->payment->method) }}</p>
                        </div>
                        @if($order->payment->transaction_id)
                            <div class="mb-4">
                                <p class="font-medium text-gray-900 dark:text-white mb-1">Transaction ID</p>
                                <p class="font-mono text-xs truncate">{{ $order->payment->transaction_id }}</p>
                            </div>
                        @endif
                        <div class="mb-2">
                            <p class="font-medium text-gray-900 dark:text-white mb-1">Payment Status</p>
                            <p class="capitalize">{{ str_replace('_', ' ', $order->payment->status) }}</p>
                        </div>
                    @else
                        <div class="mb-4">
                            <p class="font-medium text-gray-900 dark:text-white mb-1">Payment Method</p>
                            <p class="capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        </div>
                        <p>No payment details available yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const countdownElement = document.getElementById('payment-countdown');
            if (!countdownElement) return;

            const expireTimestamp = parseInt(countdownElement.getAttribute('data-expire')) * 1000;

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = expireTimestamp - now;

                if (distance <= 0) {
                    countdownElement.innerHTML = "Expired";
                    const parent = countdownElement.closest('div');
                    if (parent) {
                        parent.classList.remove('text-orange-600', 'bg-orange-50', 'dark:text-orange-400', 'dark:bg-orange-900/20');
                        parent.classList.add('text-red-600', 'bg-red-50', 'dark:text-red-400', 'dark:bg-red-900/20');
                    }
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = 
                    String(hours).padStart(2, '0') + ":" + 
                    String(minutes).padStart(2, '0') + ":" + 
                    String(seconds).padStart(2, '0');
            }

            updateCountdown();
            const timer = setInterval(updateCountdown, 1000);
        })();
    </script>
@endpush