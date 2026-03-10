@extends('layouts.app')

@section('title', 'Marketplace Blog - News, Updates, and Articles')

@section('content')
    <!-- Blog Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl mb-4">
                Our <span class="text-indigo-600 dark:text-indigo-400">Library</span>
            </h1>
            <p class="max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400">
                Get the latest news, updates, tutorials, and insights regarding our software ecosystem and development best
                practices.
            </p>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(isset($blogs) && count($blogs) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($blogs as $blog)
                        <div
                            class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">

                            <!-- Thumbnail -->
                            <a href="{{ route('blogs.show', $blog->slug) }}"
                                class="block relative w-full aspect-video bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                @if($blog->thumbnail)
                                    <img src="{{ Storage::url($blog->thumbnail) }}" alt="{{ $blog->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Request Image</div>
                                @endif
                                <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-transparent transition-colors"></div>
                            </a>

                            <!-- Content Segment -->
                            <div class="flex-1 p-6 flex flex-col justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-2">
                                        <time
                                            datetime="{{ $blog->created_at->format('Y-m-d') }}">{{ $blog->created_at->format('M d, Y') }}</time>
                                    </p>
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="block mt-2">
                                        <h3
                                            class="text-xl font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $blog->title }}
                                        </h3>
                                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400 line-clamp-3">
                                            {{ strip_tags($blog->content) }}
                                        </p>
                                    </a>
                                </div>

                                <!-- Author Profile -->
                                <div class="mt-6 flex items-center">
                                    <div class="flex-shrink-0">
                                        <span
                                            class="inline-flex h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 overflow-hidden items-center justify-center text-sm font-bold text-indigo-700 dark:text-indigo-300 ring-2 ring-white dark:ring-gray-800">
                                            {{ substr($blog->author->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $blog->author->name }}
                                        </p>
                                        <div class="flex space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                            <span>Author</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                    <div class="mt-12">
                        {{ $blogs->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div
                    class="text-center py-24 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No articles published yet</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Check back later for new updates, tips, and news.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Home
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection