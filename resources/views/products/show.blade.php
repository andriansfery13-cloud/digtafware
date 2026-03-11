@extends('layouts.app')
@section('title', $product->title . ' - DigtafWare')

@section('meta_description', Str::limit(strip_tags($product->description), 160))
@section('meta_keywords', $product->category->name . ', ' . implode(', ', explode(' ', $product->title)))

@section('og_type', 'product')
@section('og_image', $product->thumbnail ? Storage::url($product->thumbnail) : asset('images/og-product.jpg'))

@section('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org/",
    "@@type": "Product",
    "name": "{{ $product->title }}",
    "image": [
        "{{ $product->thumbnail ? Storage::url($product->thumbnail) : asset('images/og-product.jpg') }}"
    ],
    "description": "{{ strip_tags($product->description) }}",
    "sku": "PROD-{{ $product->id }}",
    "mpn": "{{ $product->id }}",
    "brand": {
        "@@type": "Brand",
        "name": "DigtafWare"
    },
    @if($product->reviews()->count() > 0)
    "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "{{ $product->average_rating }}",
        "reviewCount": "{{ $product->reviews()->count() }}"
    },
    @endif
    "offers": {
        "@@type": "Offer",
        "url": "{{ url()->current() }}",
        "priceCurrency": "IDR",
        "price": "{{ $product->price }}",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "https://schema.org/InStock"
    }
}
</script>
@endsection

@section('header', $product->title)

@section('content')
    <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 pb-16 pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="hover:text-gray-900 dark:hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <a href="{{ route('marketplace.index', ['category' => $product->category_id]) }}"
                                class="ml-1 hover:text-gray-900 dark:hover:text-white transition-colors">{{ $product->category->name }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="ml-1 text-gray-900 dark:text-gray-300 font-medium">{{ $product->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="lg:grid lg:grid-cols-3 lg:gap-x-12">

                <!-- Left Column (Images & Details) -->
                <div class="lg:col-span-2">
                    <!-- Main Image/Video -->
                    <div
                        class="aspect-video bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm mb-6 border border-gray-200 dark:border-gray-700">
                        @if($product->demo_url && str_contains($product->demo_url, 'youtube.com'))
                            @php
                                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $product->demo_url, $matches);
                                $youtubeId = $matches[1] ?? '';
                            @endphp
                            @if($youtubeId)
                                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            @endif
                        @elseif($product->thumbnail)
                            <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">No media available</div>
                        @endif
                    </div>

                    <!-- Screenshots Gallery (Alpine.js Lightbox could be added here) -->
                    @if($product->screenshots->count() > 0)
                        <div class="grid grid-cols-4 gap-4 mb-12">
                            @foreach($product->screenshots as $screenshot)
                                <div
                                    class="aspect-video bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:opacity-75 transition-opacity cursor-pointer">
                                    <img src="{{ Storage::url($screenshot->image_path) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Tabs -->
                    <div x-data="{ tab: 'description' }" class="mt-8">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <button @click="tab = 'description'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'description'}"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Description
                                </button>
                                @if($product->features)
                                    <button @click="tab = 'features'"
                                        :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'features', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'features'}"
                                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Features
                                    </button>
                                @endif
                                @if($product->requirements)
                                    <button @click="tab = 'requirements'"
                                        :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'requirements', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'requirements'}"
                                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Requirements
                                    </button>
                                @endif
                                <button @click="tab = 'changelog'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'changelog', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'changelog'}"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Changelog
                                </button>
                                <button @click="tab = 'reviews'"
                                    :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'reviews'}"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Reviews ({{ $product->reviews_count ?? $product->reviews()->count() }})
                                </button>
                            </nav>
                        </div>

                        <div class="py-6">
                            <!-- Description Tab -->
                            <div x-show="tab === 'description'"
                                class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                                {!! $product->description !!}
                            </div>

                            <!-- Features Tab -->
                            @if($product->features)
                                <div x-show="tab === 'features'" style="display: none;"
                                    class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                                    {!! $product->features !!}
                                </div>
                            @endif

                            <!-- Requirements Tab -->
                            @if($product->requirements)
                                <div x-show="tab === 'requirements'" style="display: none;"
                                    class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                                    {!! $product->requirements !!}
                                </div>
                            @endif

                            <!-- Changelog Tab -->
                            <div x-show="tab === 'changelog'" style="display: none;">
                                @if($product->changelogs && $product->changelogs->count() > 0)
                                    <div class="space-y-8">
                                        @foreach($product->changelogs as $changelog)
                                            <div class="relative pl-6 border-l-2 border-gray-200 dark:border-gray-700">
                                                <div
                                                    class="absolute w-3 h-3 bg-indigo-500 rounded-full -left-[7px] top-2 border border-white dark:border-gray-900">
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                                    v{{ $changelog->version }}
                                                    <span
                                                        class="text-sm font-normal text-gray-500">{{ $changelog->released_at->format('M d, Y') }}</span>
                                                </h4>
                                                <div
                                                    class="mt-2 text-sm text-gray-600 dark:text-gray-400 prose dark:prose-invert max-w-none">
                                                    {!! $changelog->content !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">No changelog available yet.</p>
                                @endif
                            </div>

                            <!-- Reviews Tab -->
                            <div x-show="tab === 'reviews'" style="display: none;">
                                <div class="flex items-center mb-8">
                                    <div class="text-5xl font-extrabold text-gray-900 dark:text-white mr-4">
                                        {{ number_format($product->average_rating, 1) }}</div>
                                    <div>
                                        <div class="flex text-yellow-400 mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="h-5 w-5 {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Based on
                                            {{ $product->reviews()->count() }} reviews</p>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    @forelse($product->reviews as $review)
                                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-5">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-xs">
                                                        {{ substr($review->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $review->user->name }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $review->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            @if($review->comment)
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-gray-500 dark:text-gray-400 text-sm italic">No reviews yet. Be the first
                                            to review this product after purchasing!</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Pricing & CTAs) -->
                <div class="lg:col-span-1 mt-8 lg:mt-0">
                    <div
                        class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 sticky top-24 shadow-sm">
                        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $product->title }}</h1>

                        <div class="flex items-center mb-6">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                                {{ $product->category->name }}
                            </span>
                            <div class="mx-3 text-gray-300 dark:text-gray-600">|</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                {{ $product->download_count }} Sales
                            </span>
                        </div>

                        <div class="mb-8">
                            @if($product->is_enterprise)
                                <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mb-2">Contact Us</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Enterprise tailored solution.</p>
                            @elseif($product->price == 0)
                                <p class="text-3xl font-extrabold text-green-600 dark:text-green-400 mb-2">Free Download</p>
                            @else
                                <p class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-through">Rp
                                    {{ number_format($product->price * 1.5, 0, ',', '.') }}</p>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @if($product->is_enterprise)
                                <a href="mailto:{{ config('mail.from.address', 'support@digtafware.com') }}?subject=Enterprise Inquiry: {{ $product->title }}"
                                    class="w-full bg-indigo-600 border border-transparent rounded-lg shadow-sm py-3 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    Contact Sales
                                </a>
                            @else
                                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <button type="submit" name="buy_now" value="1"
                                        class="w-full bg-green-600 border border-transparent rounded-lg shadow-sm py-3 px-4 flex items-center justify-center text-base font-bold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                        Buy Now
                                    </button>

                                    <button type="submit"
                                        class="w-full bg-indigo-600 border border-transparent rounded-lg shadow-sm py-3 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                            @endif

                            @auth
                                <form action="{{ route('dashboard.wishlist.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    @php
                                        $inWishlist = auth()->user()->wishlists()->where('product_id', $product->id)->exists();
                                    @endphp
                                    <button type="submit"
                                        class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-3 px-4 flex items-center justify-center text-base font-medium {{ $inWishlist ? 'text-red-600 border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        <svg class="h-5 w-5 mr-2 {{ $inWishlist ? 'fill-current' : 'fill-none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        {{ $inWishlist ? 'Remove from Wishlist' : 'Save to Wishlist' }}
                                    </button>
                                </form>
                            @endauth

                            @if($product->demo_url)
                                <a href="{{ $product->demo_url }}" target="_blank"
                                    class="w-full bg-slate-800 dark:bg-slate-700 border border-transparent rounded-lg shadow-sm py-3 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-slate-900 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 mt-4 transition-colors">
                                    View Live Demo
                                    <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                        </div>


                        <!-- Metadata / Info -->
                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Version</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $product->version ?? '1.0.0' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Last Updated</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $product->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">License</span>
                                <span class="font-medium text-gray-900 dark:text-white">Standard License</span>
                            </div>
                        </div>

                        <div class="mt-6 bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 flex gap-3 text-sm">
                            <svg class="h-5 w-5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-blue-700 dark:text-blue-300">
                                Includes 6 months of technical support and lifetime access to future updates.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products (Can be dynamic later, using same layout) -->
    <div class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(\App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('status', 'active')->take(4)->get() as $related)
                    <div
                        class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow border border-gray-100 dark:border-gray-700">
                        <div class="relative w-full aspect-video bg-gray-200 dark:bg-gray-700">
                            @if($related->thumbnail)
                                <img src="{{ Storage::url($related->thumbnail) }}" alt="{{ $related->title }}"
                                    class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 truncate">
                                <a href="{{ route('products.show', $related->slug) }}">{{ $related->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 truncate">{{ $related->category->name }}</p>
                            <div class="flex justify-between items-center text-sm font-medium text-gray-900 dark:text-white">
                                <span>Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection