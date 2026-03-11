@extends('layouts.dashboard')

@section('header', 'My Wishlist')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Saved Items</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Keep track of the software and templates you want to
            purchase later.</p>
    </div>

    @if(isset($wishlists) && count($wishlists) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($wishlists as $wishlist)
                @php $product = $wishlist->product; @endphp
                <div
                    class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-gray-100 dark:border-gray-700 flex flex-col h-full">
                    <!-- Image -->
                    <div class="relative w-full aspect-video bg-gray-200 dark:bg-gray-700 overflow-hidden">
                        @if($product->thumbnail)
                            <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        <!-- Category Badge -->
                        <div class="absolute top-2 right-2 flex gap-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/90 dark:bg-gray-900/90 text-gray-800 dark:text-gray-200 shadow backdrop-blur-sm">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-1 line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                            </h3>
                            <div class="flex items-center mb-4 text-sm">
                                <div class="flex items-center text-yellow-400">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span
                                        class="ml-1 text-gray-700 dark:text-gray-300 font-medium">{{ number_format($product->average_rating, 1) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-col gap-3">
                            <div class="flex justify-between items-center text-lg font-extrabold text-gray-900 dark:text-white">
                                @if($product->is_enterprise)
                                    <span class="text-sm text-indigo-600 dark:text-indigo-400">Contact Us</span>
                                @elseif($product->price == 0)
                                    <span class="text-green-600 dark:text-green-400">Free</span>
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        Move to Cart
                                    </button>
                                </form>

                                <form action="{{ route('dashboard.wishlist.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" title="Remove from wishlist"
                                        class="flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-red-600 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($wishlists->hasPages())
            <div class="mt-8">
                {{ $wishlists->links() }}
            </div>
        @endif
    @else
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 py-16 px-4 flex flex-col items-center justify-center text-center">
            <div class="h-20 w-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Your wishlist is empty</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-sm">Save items you like to your wishlist to quickly find them
                later when you're ready to buy.</p>
            <a href="{{ route('marketplace.index') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                Discover Products
            </a>
        </div>
    @endif

@endsection