@extends('layouts.dashboard')

@section('header', 'Invoice #' . $order->order_number)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('dashboard.orders.show', $order->id) }}"
                class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
                Order</a>
            <a href="{{ route('dashboard.invoices.download', $order->id) }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download PDF
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            {{-- Invoice Header --}}
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-6">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div
                                class="w-8 h-8 rounded bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                D</div>
                            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">DigtafWare</span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">PT DigtafWare Solution</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Jakarta, Indonesia</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">INVOICE</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Invoice No:</span>
                            {{ $order->order_number }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Date:</span>
                            {{ $order->created_at->format('M d, Y') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">Paid</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bill To --}}
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Bill To
                </h3>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user->email }}</p>
            </div>

            {{-- Items Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Item</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Category</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Price</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $item->product->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->product->category->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="p-6 sm:p-8 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
                <div class="flex justify-end">
                    <div class="w-full sm:w-64 space-y-2">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <div
                            class="flex justify-between text-base font-bold text-gray-900 dark:text-white border-t border-gray-200 dark:border-gray-700 pt-2">
                            <span>Total</span>
                            <span class="text-indigo-600 dark:text-indigo-400">Rp
                                {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Info --}}
            @if($order->payment)
                <div class="p-6 sm:p-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Payment
                        Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Method</p>
                            <p class="font-medium text-gray-900 dark:text-white capitalize">
                                {{ str_replace('_', ' ', $order->payment->method) }}</p>
                        </div>
                        @if($order->payment->transaction_id)
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Transaction ID</p>
                                <p class="font-medium font-mono text-gray-900 dark:text-white text-xs">
                                    {{ $order->payment->transaction_id }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Payment Status</p>
                            <p class="font-medium text-gray-900 dark:text-white capitalize">{{ $order->payment->status }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Footer --}}
            <div
                class="p-6 sm:p-8 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30 text-center">
                <p class="text-xs text-gray-400 dark:text-gray-500">Thank you for your purchase! This invoice was generated
                    automatically by DigtafWare.</p>
            </div>
        </div>
    </div>
@endsection