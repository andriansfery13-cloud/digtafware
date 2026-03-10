@extends('layouts.app')

@section('header', 'Marketplace')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Hero / Title -->
        <div class="mb-8 md:mb-12 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight sm:text-4xl">Browse Software
                Products</h1>
            <p class="mt-4 max-w-2xl text-lg text-gray-500 dark:text-gray-400">Find the perfect script, theme, or plugin to
                accelerate your next project.</p>
        </div>

        <!-- Filters and Grid -->
        <div class="flex flex-col md:flex-row gap-8">

            <!-- Sidebar Filters -->
            <div class="w-full md:w-64 flex-shrink-0">
                <form action="{{ route('marketplace.index') }}" method="GET"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 sticky top-24">

                    <!-- Search Keyword -->
                    <div class="mb-6">
                        <label for="search"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                                placeholder="Keywords...">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="cat-all" name="category" type="radio" value="" {{ request('category') == '' ? 'checked' : '' }}
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                <label for="cat-all" class="ml-3 block text-sm text-gray-600 dark:text-gray-400">All
                                    Categories</label>
                            </div>
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input id="cat-{{ $category->id }}" name="category" type="radio" value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'checked' : '' }}
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                    <label for="cat-{{ $category->id }}"
                                        class="ml-3 block text-sm text-gray-600 dark:text-gray-400">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div class="mb-6">
                        <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort
                            By</label>
                        <select id="sort" name="sort"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                                High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to
                                Low</option>
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Apply Filters
                        </button>
                        @if(request()->anyFilled(['search', 'category', 'sort']))
                            <a href="{{ route('marketplace.index') }}"
                                class="mt-3 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Clear All
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Product Grid -->
            <div class="flex-1">
                <div class="mb-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                    <p>Showing <strong>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> of
                        <strong>{{ $products->total() }}</strong> results</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <div
                            class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col h-full transform hover:-translate-y-1">
                            <div class="relative w-full aspect-video bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                @if($product->thumbnail)
                                    <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                                <!-- Category Badge -->
                                <div class="absolute top-2 right-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/90 dark:bg-gray-900/90 text-gray-800 dark:text-gray-200 shadow backdrop-blur-sm">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3
                                        class="text-lg font-bold text-gray-900 dark:text-white mb-1 line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
                                        {{ $product->description }}</p>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center mb-4 text-sm scale-95 origin-left">
                                    <div class="flex items-center text-yellow-400">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span
                                            class="ml-1 text-gray-700 dark:text-gray-300 font-medium">{{ number_format($product->average_rating, 1) }}</span>
                                    </div>
                                    <span class="mx-2 text-gray-300 dark:text-gray-600">|</span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ $product->download_count }} sales</span>
                                </div>

                                <div
                                    class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
                                    <p class="text-lg font-extrabold text-gray-900 dark:text-white">
                                        @if($product->is_enterprise)
                                            <span
                                                class="text-sm text-indigo-600 dark:text-indigo-400 font-semibold uppercase tracking-wider">Contact
                                                Us</span>
                                        @elseif($product->price == 0)
                                            <span class="text-green-600 dark:text-green-400">Free</span>
                                        @else
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        @endif
                                    </p>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit"
                                            class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 dark:hover:text-indigo-400 transition-colors"
                                            title="Add to Cart">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col items-center justify-center">
                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">No products found</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">We couldn't find
                                anything matching your current filters. Try adjusting your search or category selection.</p>
                            <a href="{{ route('marketplace.index') }}"
                                class="mt-6 text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Clear all filters &rarr;
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection