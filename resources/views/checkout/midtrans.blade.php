@extends('layouts.app')

@section('header', 'Complete Payment')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-theme('spacing.16'))] py-16 flex items-center justify-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden text-center p-8 sm:p-12">
                <div
                    class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-blue-100 dark:bg-blue-900/30 mb-8">
                    <svg class="h-12 w-12 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">Complete Your Payment
                </h1>
                <p class="text-lg text-gray-500 dark:text-gray-400 mb-8">Order <span
                        class="font-semibold text-gray-900 dark:text-white">#{{ $order->order_number }}</span>. Total: Rp
                    {{ number_format($order->total, 0, ',', '.') }}</p>

                <button id="pay-button"
                    class="w-full inline-flex justify-center items-center px-8 py-4 border border-transparent rounded-lg shadow-lg text-lg font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 transition-all transform hover:-translate-y-1">
                    Pay Now with Midtrans
                </button>

                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
                    You will be redirected back once the payment is processed.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script type="text/javascript">
            const payButton = document.getElementById('pay-button');
            const snapToken = '{{ $snapToken }}';

            payButton.onclick = function () {
                snap.pay(snapToken, {
                    onSuccess: function (result) {
                        window.location.href = "{{ route('checkout.success', $order->id) }}";
                    },
                    onPending: function (result) {
                        window.location.href = "{{ route('checkout.success', $order->id) }}";
                    },
                    onError: function (result) {
                        alert("payment failed!");
                        console.log(result);
                    },
                    onClose: function () {
                        console.log('customer closed the popup without finishing the payment');
                    }
                });
            };

            // Auto-trigger the popup
            window.onload = function () {
                payButton.click();
            };
        </script>
    @endpush

    <!-- Render the scripts stack within the content section for layouts that don't have it in the footer -->
    @stack('scripts')
@endsection