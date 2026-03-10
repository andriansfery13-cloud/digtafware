@extends('layouts.dashboard')

@section('header', 'My Reviews')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Product Reviews</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Share your experiences with products you've purchased.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 dark:bg-green-900/40 p-4 border border-green-200 dark:border-green-800">
            <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Purchased but unreviewed products -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Awaiting Your Review
                    </h3>
                </div>

                @if(isset($unreviewedProducts) && $unreviewedProducts->count() > 0)
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($unreviewedProducts as $product)
                            <li class="p-6 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-12 w-16 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
                                        @if($product->thumbnail)
                                            <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p
                                            class="text-sm font-bold text-gray-900 dark:text-white truncate max-w-[150px] sm:max-w-xs">
                                            {{ $product->title }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('dashboard.reviews.create', ['product_id' => $product->id]) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 shadow-sm text-xs font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    Write Review
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        You've reviewed all your completed purchases. Thanks!
                    </div>
                @endif
            </div>

            <!-- Past Reviews List -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Your Past Reviews</h3>
                </div>

                @if(isset($reviews) && $reviews->count() > 0)
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($reviews as $review)
                            <li class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1"><a
                                            href="{{ route('products.show', $review->product->slug) }}">{{ $review->product->title }}</a>
                                    </p>
                                    <div class="flex" aria-label="Rating: {{ $review->rating }} out of 5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $review->comment }}</p>
                                <div class="mt-2 text-xs text-gray-500">
                                    Posted on {{ $review->created_at->format('M d, Y') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    @if($reviews->hasPages())
                        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 sm:px-6">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        You haven't written any reviews yet.
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection