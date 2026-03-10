@extends('layouts.app')

@section('header', 'Your Cart')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-theme('spacing.16'))] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 gap-3 flex items-center">
                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Shopping Cart
            </h1>

            @if(count($cartItems) > 0)
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">

                    <!-- Cart Items List -->
                    <div class="lg:col-span-8">
                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($cartItems as $item)
                                    <li class="flex py-6 px-4 sm:px-6">
                                        <div
                                            class="flex-shrink-0 w-24 h-24 border border-gray-200 dark:border-gray-700 rounded-md overflow-hidden bg-gray-100 dark:bg-gray-700">
                                            @if($item['product']->thumbnail)
                                                <img src="{{ Storage::url($item['product']->thumbnail) }}"
                                                    alt="{{ $item['product']->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div
                                                    class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                                    <h3 class="line-clamp-2">
                                                        <a
                                                            href="{{ route('products.show', $item['product']->slug) }}">{{ $item['product']->title }}</a>
                                                    </h3>
                                                    <p class="ml-4 whitespace-nowrap">Rp
                                                        {{ number_format($item['price'], 0, ',', '.') }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $item['product']->category->name }}</p>
                                            </div>
                                            <div class="flex-1 flex items-end justify-between text-sm">
                                                <p class="text-gray-500 dark:text-gray-400 flex items-center">
                                                    <svg class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Digital Download
                                                </p>

                                                <div class="flex">
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                        <button type="submit"
                                                            class="font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300">Remove</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-4 mt-8 lg:mt-0">
                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Order summary</h2>

                            <dl class="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center justify-between">
                                    <dt>Subtotal</dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</dd>
                                </div>

                                <!-- Coupon Check -->
                                @if($couponCode)
                                    <div
                                        class="flex items-center justify-between text-green-600 dark:text-green-400 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <dt class="flex items-center">
                                            Discount ({{ $couponCode }})
                                            <form action="{{ route('cart.coupon.remove') }}" method="POST" class="ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500"
                                                    title="Remove Coupon">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </dt>
                                        <dd class="font-medium">- Rp {{ number_format($discountValue, 0, ',', '.') }}</dd>
                                    </div>
                                @endif

                                <div
                                    class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                    <dt class="text-base font-bold text-gray-900 dark:text-white">Order Total</dt>
                                    <dd class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Rp
                                        {{ number_format($total, 0, ',', '.') }}</dd>
                                </div>
                            </dl>

                            <!-- Promo Code Form -->
                            @if(!$couponCode)
                                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                                    <form action="{{ route('cart.coupon.apply') }}" method="POST">
                                        @csrf
                                        <label for="code"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Have a promo
                                            code?</label>
                                        <div class="flex space-x-2">
                                            <input type="text" name="code" id="code"
                                                class="block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2"
                                                placeholder="Enter code">
                                            <button type="submit"
                                                class="bg-gray-100 dark:bg-gray-700 border border-transparent rounded-md shadow-sm px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none transition-colors">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                                @auth
                                    <a href="{{ route('checkout.index') }}"
                                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        Proceed to Checkout
                                    </a>
                                @else
                                    <a href="{{ route('login', ['redirect' => route('cart.index')]) }}"
                                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors mb-3">
                                        Sign in to Checkout
                                    </a>
                                    <p
                                        class="text-xs text-center text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">
                                        Or</p>
                                    <a href="{{ route('register') }}"
                                        class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-base font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none transition-colors">
                                        Create an Account
                                    </a>
                                @endauth
                            </div>

                            <div class="mt-6 flex justify-center text-sm text-gray-500 dark:text-gray-400">
                                <p>
                                    or <a href="{{ route('marketplace.index') }}"
                                        class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium">Continue
                                        Shopping<span aria-hidden="true"> &rarr;</span></a>
                                </p>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="mt-6 flex justify-center gap-4 text-gray-400 opacity-60">
                            <!-- Simplified representation of payment badges -->
                            <div class="flex items-center gap-1 text-xs"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg> Secure Payment</div>
                            <div class="flex items-center gap-1 text-xs"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg> Midtrans Supported</div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 py-16 px-4 sm:px-6 flex flex-col items-center justify-center text-center">
                    <div class="h-24 w-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-medium text-gray-900 dark:text-white mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm">Looks like you haven't added any premium software
                        to your cart yet.</p>
                    <a href="{{ route('marketplace.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Browse Marketplace
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection