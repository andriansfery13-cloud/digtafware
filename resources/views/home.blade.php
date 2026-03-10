@extends('layouts.app')

@section('header', 'Welcome')

@section('content')
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 sm:pt-16 lg:pt-20">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Premium Software</span>
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Scripts & Plugins</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Discover high-quality software solutions, premium web templates, and powerful development tools built by exceptional creators.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('marketplace.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg transition-colors">
                                    Browse Marketplace
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#popular" class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 dark:border-gray-700 text-base font-medium rounded-md text-indigo-700 dark:text-indigo-400 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 md:py-4 md:text-lg transition-colors shadow-sm">
                                    View Popular
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Decorative SVG / Image -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 hidden lg:block bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-l-3xl">
            <div class="h-full w-full flex items-center justify-center p-12">
                 <div class="w-full h-full bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 border border-gray-100 dark:border-gray-700 flex flex-col gap-4 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                    <div class="h-8 w-2/3 bg-gray-100 dark:bg-gray-700 rounded-md"></div>
                    <div class="flex-1 rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-900">
                        <svg class="h-24 w-24 text-indigo-200 dark:text-indigo-900/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-indigo-700 dark:bg-indigo-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to build something?</span>
                <span class="block text-indigo-200">Search for the perfect tool.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0 w-full max-w-md">
                <form action="{{ route('marketplace.index') }}" method="GET" class="w-full sm:flex shadow-sm rounded-md">
                    <label for="search" class="sr-only">Search products</label>
                    <input type="text" name="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white px-4 py-3" placeholder="e.g. POS System, Dashboard Template...">
                    <button type="submit" class="-ml-px relative inline-flex items-center space-x-2 px-6 py-3 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Search</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Popular Products -->
        <div id="popular" class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Popular & Featured</h2>
                <a href="{{ route('marketplace.index', ['sort' => 'popular']) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 flex items-center">
                    See all
                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($popularProducts as $product)
                    <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col h-full transform hover:-translate-y-1">
                        <div class="relative w-full aspect-video bg-gray-200 dark:bg-gray-700 overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/90 dark:bg-gray-900/90 text-gray-800 dark:text-gray-200 shadow backdrop-blur-sm">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>
                            </div>
                            
                            <!-- Rating -->
                            <div class="flex items-center mb-4 text-sm">
                                <div class="flex items-center text-yellow-400">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    <span class="ml-1 text-gray-700 dark:text-gray-300 font-medium">{{ number_format($product->average_rating, 1) }}</span>
                                </div>
                                <span class="mx-2 text-gray-300 dark:text-gray-600">|</span>
                                <span class="text-gray-500 dark:text-gray-400">{{ $product->download_count }} sales</span>
                            </div>

                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
                                <p class="text-xl font-extrabold text-gray-900 dark:text-white">
                                    @if($product->is_enterprise)
                                        <span class="text-base text-indigo-600 dark:text-indigo-400 font-semibold">Contact Us</span>
                                    @elseif($product->price == 0)
                                        <span class="text-green-600 dark:text-green-400">Free</span>
                                    @else
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @endif
                                </p>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 dark:hover:text-indigo-400 transition-colors" title="Add to Cart">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-12 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Check back later for awesome software products.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- New Products -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Newest Additions</h2>
                <a href="{{ route('marketplace.index', ['sort' => 'newest']) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 flex items-center">
                    See all
                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($newProducts as $product)
                     <a href="{{ route('products.show', $product->slug) }}" class="group flex items-start bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 relative h-20 w-20 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-1">
                                {{ $product->title }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 line-clamp-1">{{ $product->category->name }}</p>
                            <div class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                @if($product->is_enterprise)
                                    Contact Us
                                @elseif($product->price == 0)
                                    Free
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                     </a>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-8 text-gray-500">No new products.</div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
