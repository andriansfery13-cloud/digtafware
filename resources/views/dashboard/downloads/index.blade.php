@extends('layouts.dashboard')

@section('header', 'My Downloads & Licenses')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Downloads & Licenses</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Access your purchased software, download files, and view
            license keys.</p>
    </div>

    @if(session('error'))
        <div
            class="mb-8 rounded-md bg-red-50 dark:bg-red-900/40 p-4 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">
        @forelse($downloads as $download)
            @php
                $product = $download->product;
                // Get license associated with this order/product
                $license = \App\Models\License::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->where('order_id', $download->order_id)
                    ->first();
            @endphp

            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col md:flex-row">
                <!-- Product Info & Image -->
                <div
                    class="w-full md:w-1/3 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-850 p-6 flex flex-col justify-center">
                    <div
                        class="aspect-video w-full rounded-lg overflow-hidden bg-gray-200 dark:bg-gray-700 mb-4 border border-gray-100 dark:border-gray-600 shadow-sm relative group">
                        @if($product->thumbnail)
                            <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1"><a
                            href="{{ route('products.show', $product->slug) }}"
                            class="hover:underline">{{ $product->title }}</a></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category->name }}</p>
                    <p class="text-xs text-gray-400 mt-2">Purchased on {{ $download->created_at->format('M d, Y') }}</p>
                </div>

                <!-- Download & License Action Area -->
                <div class="w-full md:w-2/3 p-6 flex flex-col">

                    <!-- Latest Version Download Details -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white">Latest Version
                                ({{ $product->version ?? '1.0' }})</h4>
                            @if($download->expires_at)
                                <span
                                    class="text-xs font-medium px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-md shadow-sm">
                                    Updates until {{ $download->expires_at->format('M d, Y') }}
                                </span>
                            @else
                                <span
                                    class="text-xs font-medium px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-md shadow-sm">
                                    Lifetime Updates
                                </span>
                            @endif
                        </div>

                        @if($product->changelogs->count() > 0)
                            <div
                                class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 mb-6 text-sm border border-gray-100 dark:border-gray-700">
                                <strong>What's new in {{ $product->changelogs->first()->version }}:</strong>
                                <div class="text-gray-600 dark:text-gray-400 mt-1 line-clamp-2 prose prose-sm dark:prose-invert">
                                    {!! strip_tags($product->changelogs->first()->content) !!}
                                </div>
                            </div>
                        @endif

                        <!-- License Key Display (If applicable) -->
                        @if($license)
                            <div class="mb-6">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">License Key</p>
                                <div class="flex">
                                    <code
                                        class="flex-1 bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-l-md border border-gray-200 dark:border-gray-700 font-mono text-sm break-all font-bold tracking-wide"
                                        id="license-{{ $license->id }}">
                                                            {{ $license->key }}
                                                        </code>
                                    <button
                                        onclick="navigator.clipboard.writeText('{{ $license->key }}'); this.innerText='Copied!'; setTimeout(() => this.innerText='Copy', 2000);"
                                        class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-4 py-2 border border-l-0 border-indigo-200 dark:border-indigo-800 rounded-r-md text-sm font-medium hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors focus:outline-none">
                                        Copy
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Activated:
                                    {{ $license->activated_devices }}/{{ $license->device_limit ?? '∞' }} devices
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Main Download Button -->
                    <div
                        class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            @if($download->max_downloads > 0)
                                Downloads remaining: <strong
                                    class="text-gray-900 dark:text-white">{{ $download->max_downloads - $download->download_count }}</strong>
                            @else
                                Unlimited downloads
                            @endif
                        </p>
                        <a href="{{ route('download.process', ['token' => $download->token]) }}"
                            class="w-full sm:w-auto flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Latest File
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 py-16 px-4 flex flex-col items-center justify-center text-center">
                <div class="h-20 w-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </div>
                <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No downloads available</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-sm">You haven't purchased any products yet, or your orders
                    are still pending verification.</p>
                <a href="{{ route('marketplace.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    Browse Products
                </a>
            </div>
        @endforelse

        @if(isset($downloads) && $downloads->hasPages())
            <div class="mt-6">
                {{ $downloads->links() }}
            </div>
        @endif
    </div>
@endsection