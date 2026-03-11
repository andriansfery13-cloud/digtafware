@extends('layouts.admin')

@section('header')
    Order Details #{{ $order->order_number }}
@endsection

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to Orders</a>

        <div>
            @if($order->status == 'paid')
                <span
                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400 shadow-sm">Paid</span>
            @elseif($order->status == 'verifying')
                <span
                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400 shadow-sm animate-pulse">Needs
                    Verification</span>
            @else
                <span
                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 shadow-sm">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 dark:bg-green-900/40 p-4 border border-green-200 dark:border-green-800">
            <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            <!-- Order Items -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Purchased Items</h3>
                </div>

                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        <li class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                @if($item->product->thumbnail)
                                    <img src="{{ Storage::url($item->product->thumbnail) }}"
                                        class="h-16 w-24 object-cover rounded border border-gray-200 dark:border-gray-700">
                                @endif
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white"><a
                                            href="{{ route('products.show', $item->product->slug) }}" target="_blank"
                                            class="hover:underline">{{ $item->product->title }}</a></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Category:
                                        {{ $item->product->category->name }}
                                    </p>
                                    @if($item->license_key)
                                        <p class="text-xs font-mono text-indigo-600 dark:text-indigo-400 mt-1 mt-1">Key:
                                            {{ $item->license_key }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="font-medium text-gray-900 dark:text-white">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div
                    class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30 font-bold flex justify-between text-lg">
                    <span class="text-gray-900 dark:text-white">Total</span>
                    <span class="text-indigo-600 dark:text-indigo-400">Rp
                        {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Manual Payment Verification Action Area -->
            @if($order->status == 'verifying' && $order->payment_method == 'manual')
                <div
                    class="bg-blue-50 dark:bg-blue-900/20 shadow-sm rounded-xl border border-blue-200 dark:border-blue-800 overflow-hidden">
                    <div class="px-6 py-5 border-b border-blue-200 dark:border-blue-800 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg leading-6 font-medium text-blue-900 dark:text-blue-100">Manual Payment Verification
                            Required</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Proof of Transfer</p>
                                @if($order->payment && $order->payment->proof_image)
                                    <a href="{{ Storage::url($order->payment->proof_image) }}" target="_blank"
                                        class="block border border-blue-200 dark:border-blue-700 rounded-md overflow-hidden hover:opacity-80 transition-opacity">
                                        <img src="{{ Storage::url($order->payment->proof_image) }}" alt="Payment Proof"
                                            class="w-full h-auto">
                                    </a>
                                @else
                                    <p class="text-sm text-red-600">No proof image uploaded by user.</p>
                                @endif
                            </div>
                            <div class="w-full md:w-1/2 flex flex-col justify-center gap-4">
                                <form action="{{ route('admin.orders.verify', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="success">
                                    <button type="submit"
                                        class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm">
                                        Approve Payment
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2 text-center">This will set order to paid and generate
                                        licenses.</p>
                                </form>

                                <form action="{{ route('admin.orders.verify', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="failed">
                                    <button type="submit"
                                        onclick="return confirm('Reject this payment proof? Order will revert to pending.');"
                                        class="w-full flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium text-red-600 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reject Proof
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="lg:col-span-1 space-y-8">
            <!-- Customer Details -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Customer Profile</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div
                            class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center font-bold text-indigo-700 dark:text-indigo-300">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    <div
                        class="border-t border-gray-200 dark:border-gray-700 pt-4 text-sm text-gray-500 dark:text-gray-400">
                        <p class="mb-1"><strong class="text-gray-700 dark:text-gray-300">Registered:</strong>
                            {{ $order->user->created_at->format('M d, Y') }}</p>
                        <p><strong class="text-gray-700 dark:text-gray-300">Total Orders:</strong>
                            {{ $order->user->orders()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Payment Log</h3>
                </div>
                <div class="p-6 text-sm text-gray-600 dark:text-gray-400 space-y-4">
                    <div>
                        <span class="block text-xs font-medium text-gray-500 uppercase">Method</span>
                        <span
                            class="block text-base font-medium text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    </div>

                    @if($order->payment)
                        @if($order->payment->transaction_id)
                            <div>
                                <span class="block text-xs font-medium text-gray-500 uppercase">Gateway Tx ID</span>
                                <span
                                    class="block font-mono text-gray-900 dark:text-white">{{ $order->payment->transaction_id }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="block text-xs font-medium text-gray-500 uppercase">Status</span>
                            <span class="block capitalize">{{ $order->payment->status }}</span>
                        </div>
                    @else
                        <p>No payment record generated yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection