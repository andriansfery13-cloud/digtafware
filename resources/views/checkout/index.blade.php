@extends('layouts.app')

@section('header', 'Checkout')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-theme('spacing.16'))] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <a href="{{ route('cart.index') }}"
                    class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
                    Cart</a>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8">Secure Checkout</h1>

            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start space-y-8 lg:space-y-0">

                <!-- Checkout Form & Payment Selection -->
                <div class="lg:col-span-7">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf

                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden mb-8">
                            <div
                                class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center">
                                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Account Details
                                </h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                        <div class="mt-1">
                                            <input type="text" value="{{ auth()->user()->name }}" disabled
                                                class="bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 dark:text-gray-400 text-gray-500 block w-full shadow-sm sm:text-sm rounded-md cursor-not-allowed">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                            Address</label>
                                        <div class="mt-1">
                                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                                class="bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 dark:text-gray-400 text-gray-500 block w-full shadow-sm sm:text-sm rounded-md cursor-not-allowed">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 flex items-center">
                                    <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Keys and downloads will be associated with this account.
                                </p>
                            </div>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                            <div
                                class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center">
                                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Payment Method
                                </h3>
                            </div>
                            <div class="p-6">
                                @if($total == 0)
                                    <div class="bg-green-50 dark:bg-green-900/40 p-4 rounded-md flex items-start">
                                        <svg class="h-6 w-6 text-green-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <h4 class="text-green-800 dark:text-green-400 font-medium">Free Order</h4>
                                            <p class="text-sm text-green-700 dark:text-green-500 mt-1">Your entire order is
                                                free. No payment is required.</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="payment_method" value="free">
                                @else
                                    <div class="space-y-4">
                                        <label
                                            class="relative flex cursor-pointer rounded-lg border bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none has-[:checked]:border-indigo-500 has-[:checked]:ring-1 has-[:checked]:ring-indigo-500 transition-all border-gray-300 dark:border-gray-700">
                                            <input type="radio" name="payment_method" value="midtrans" class="sr-only" checked>
                                            <span class="flex flex-1">
                                                <span class="flex flex-col">
                                                    <span
                                                        class="block text-sm font-medium text-gray-900 dark:text-white">Midtrans
                                                        (Instant)</span>
                                                    <span
                                                        class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">Credit
                                                        Card, GoPay, Qris, Virtual Account</span>
                                                </span>
                                            </span>
                                            <svg class="h-5 w-5 text-indigo-600 hidden group-has-[:checked]:block"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </label>

                                        <label
                                            class="relative flex cursor-pointer rounded-lg border bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none has-[:checked]:border-indigo-500 has-[:checked]:ring-1 has-[:checked]:ring-indigo-500 transition-all border-gray-300 dark:border-gray-700">
                                            <input type="radio" name="payment_method" value="manual" class="sr-only">
                                            <span class="flex flex-1">
                                                <span class="flex flex-col">
                                                    <span class="block text-sm font-medium text-gray-900 dark:text-white">Manual
                                                        Bank Transfer</span>
                                                    <span
                                                        class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">BCA,
                                                        Mandiri - Requires manual verification (1-24 hours)</span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="w-full md:w-auto bg-indigo-600 border border-transparent rounded-lg shadow-sm py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                {{ $total == 0 ? 'Complete Order' : 'Place Order' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-5">
                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-6 sticky top-24">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Order Summary</h2>

                        <div class="flow-root mb-6">
                            <ul role="list" class="-my-4 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($cartItems as $item)
                                    <li class="flex items-center py-4">
                                        <div
                                            class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700">
                                            @if($item['product']->thumbnail)
                                                <img src="{{ Storage::url($item['product']->thumbnail) }}"
                                                    class="h-full w-full object-cover object-center">
                                            @endif
                                        </div>
                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div
                                                    class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                                    <h3 class="line-clamp-1 text-sm"><a
                                                            href="{{ route('products.show', $item['product']->slug) }}">{{ $item['product']->title }}</a>
                                                    </h3>
                                                    <p class="ml-4 text-sm font-semibold">Rp
                                                        {{ number_format($item['price'], 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">{{ $item['product']->category->name }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <dl
                            class="space-y-4 text-sm text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex items-center justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</dd>
                            </div>

                            @if($couponCode)
                                <div class="flex items-center justify-between text-green-600 dark:text-green-400">
                                    <dt>Discount ({{ $couponCode }})</dt>
                                    <dd class="font-medium">- Rp {{ number_format($discountValue, 0, ',', '.') }}</dd>
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <dt>Taxes</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">Included</dd>
                            </div>

                            <div
                                class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Rp
                                    {{ number_format($total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                By placing this order, you agree to our <a href="#"
                                    class="text-indigo-600 hover:underline">Terms of Service</a> and <a href="#"
                                    class="text-indigo-600 hover:underline">Privacy Policy</a>. Software licenses are bound
                                to this account and are non-transferable.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection