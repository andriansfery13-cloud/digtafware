@extends('layouts.app')

@section('header', 'Payment & Success')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-theme('spacing.16'))] py-16 flex items-center justify-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden text-center p-8 sm:p-12">

                <div
                    class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 dark:bg-green-900/30 mb-8">
                    <svg class="h-12 w-12 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                @if($order->status === 'paid')
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">Payment Successful!
                    </h1>
                    <p class="text-lg text-gray-500 dark:text-gray-400 mb-8">Thank you for your purchase. Your order <span
                            class="font-semibold text-gray-900 dark:text-white">#{{ $order->order_number }}</span> has been
                        completed.</p>

                    <div
                        class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 mb-8 text-left border border-gray-100 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">What's next?</h3>
                        <ul class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Download your software files from your dashboard.</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <span>Access your unique license keys for activation.</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>An invoice has been sent to your email.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('dashboard.downloads') }}"
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                            Go to Downloads
                        </a>
                        <a href="{{ route('marketplace.index') }}"
                            class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Continue Shopping
                        </a>
                    </div>

                @elseif($order->status === 'pending_payment')

                    @if($order->payment_method === 'midtrans' && $order->payment && $order->payment->snap_token)
                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">Complete Your Payment
                        </h1>
                        <p class="text-lg text-gray-500 dark:text-gray-400 mb-8">Order #{{ $order->order_number }} created
                            successfully. Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>

                        <!-- Midtrans Pay Button -->
                        <button id="pay-button"
                            class="w-full inline-flex justify-center items-center px-8 py-4 border border-transparent rounded-lg shadow-lg text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 transition-all transform hover:-translate-y-1">
                            Pay with Midtrans Now
                        </button>

                        <p
                            class="mt-4 text-sm text-gray-500 dark:text-gray-400 font-medium pb-4 border-b border-gray-200 dark:border-gray-700">
                            or <a href="{{ route('dashboard.orders.show', $order->id) }}"
                                class="text-indigo-600 hover:underline">Pay Later via Dashboard</a></p>

                        <!-- Midtrans Script Block -->
                        @push('scripts')
                            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                                data-client-key="{{ config('services.midtrans.client_key') }}"></script>
                            <script type="text/javascript">
                                document.getElementById('pay-button').onclick = function () {
                                    snap.pay('{{ $order->payment->snap_token }}', {
                                        onSuccess: function (result) {
                                            window.location.href = "{{ route('checkout.success', $order->id) }}";
                                        },
                                        onPending: function (result) {
                                            alert("wating your payment!"); console.log(result);
                                        },
                                        onError: function (result) {
                                            alert("payment failed!"); console.log(result);
                                        },
                                        onClose: function () {
                                            console.log('customer closed the popup without finishing the payment');
                                        }
                                    })
                                };
                            </script>
                        @endpush
                    @else
                        <!-- Fallback if missing token etc -->
                        <h1 class="text-3xl font-extrabold text-yellow-600 dark:text-yellow-500 tracking-tight mb-2">Order Pending
                        </h1>
                        <p class="text-gray-500 mb-6">Payment needs to be completed via dashboard.</p>
                        <a href="{{ route('dashboard.orders') }}"
                            class="btn inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600">View
                            Orders</a>
                    @endif

                @elseif($order->status === 'verifying')
                    <div
                        class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-blue-100 dark:bg-blue-900/30 mb-8 -mt-20">
                        <svg class="h-12 w-12 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">Payment Verifying</h1>
                    <p class="text-lg text-gray-500 dark:text-gray-400 mb-8">We have received your payment proof for Order <span
                            class="font-semibold text-gray-900 dark:text-white">#{{ $order->order_number }}</span>.</p>
                    <p class="text-gray-600 dark:text-gray-300 mb-8 max-w-md mx-auto">
                        Our admin team is currently verifying your manual transfer. This usually takes 1-2 hours during business
                        hours. We'll send you an email once verified.
                    </p>
                    <div class="flex justify-center">
                        <a href="{{ route('dashboard.orders.show', $order->id) }}"
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                            View Order Status
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
    <!-- Simple push for scripts if not present -->
    @stack('scripts')
@endsection