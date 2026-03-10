@extends('layouts.dashboard')

@section('header', 'Write a Review')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard.reviews.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to My
            Reviews</a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden max-w-3xl mx-auto">
        <div
            class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Review Product</h3>
        </div>

        @if(isset($product))
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center">
                <div class="h-16 w-24 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
                    @if($product->thumbnail)
                        <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="ml-4">
                    <p class="text-base font-bold text-gray-900 dark:text-white"><a
                            href="{{ route('products.show', $product->slug) }}" target="_blank"
                            class="hover:underline">{{ $product->title }}</a></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category->name }} &bull; Purchased Software
                    </p>
                </div>
            </div>
        @endif

        <form action="{{ route('dashboard.reviews.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="product_id" value="{{ request('product_id') }}">

            <!-- Rating Select Component using radio buttons styled as stars structure -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Rating <span
                        class="text-red-500">*</span></label>
                <div class="flex items-center space-x-2" x-data="{ rating: {{ old('rating', 5) }} }">
                    <template x-for="i in 5">
                        <button type="button" @click="rating = i"
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-full">
                            <svg class="h-8 w-8 cursor-pointer transition-colors"
                                :class="rating >= i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                    <input type="hidden" name="rating" x-model="rating">
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400" x-text="rating + ' out of 5'"></span>
                </div>
                @error('rating') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Review
                    <span class="text-red-500">*</span></label>
                <textarea id="comment" name="comment" rows="5" required
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                    placeholder="Tell others what you think about this product based on your experience.">{{ old('comment') }}</textarea>
                @error('comment') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-5 flex justify-end gap-3">
                <a href="{{ route('dashboard.reviews.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
@endsection