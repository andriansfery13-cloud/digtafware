@extends('layouts.app')

@section('title', $blog->title . ' - Blog')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <article
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

                <!-- Article Header -->
                <header class="px-6 py-8 sm:p-10 text-center border-b border-gray-100 dark:border-gray-800">
                    <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-4">
                        Published <time
                            datetime="{{ $blog->created_at->format('Y-m-d') }}">{{ $blog->created_at->format('F d, Y') }}</time>
                    </p>

                    <h1
                        class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight mb-8">
                        {{ $blog->title }}
                    </h1>

                    <div class="flex items-center justify-center">
                        <div class="flex items-center">
                            <span
                                class="inline-flex h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 overflow-hidden items-center justify-center text-lg font-bold text-indigo-700 dark:text-indigo-300 ring-2 ring-white dark:ring-gray-800">
                                {{ substr($blog->author->name, 0, 1) }}
                            </span>
                            <div class="ml-4 text-left">
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $blog->author->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Written by Administrator</p>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Featured Image -->
                @if($blog->thumbnail)
                    <div class="w-full aspect-video bg-gray-200 dark:bg-gray-900 relative">
                        <img src="{{ Storage::url($blog->thumbnail) }}" alt="{{ $blog->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="px-6 py-10 sm:px-12 prose prose-indigo prose-lg dark:prose-invert max-w-none">
                    {!! $blog->content !!}
                </div>

                <!-- Article Footer -->
                <footer
                    class="px-6 py-8 sm:px-12 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex gap-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Share this article:</span>
                        <div class="flex gap-3">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}"
                                target="_blank" class="text-gray-400 hover:text-indigo-500 transition-colors">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('blogs.index') }}"
                            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 flex items-center gap-1">
                            &larr; Back to all posts
                        </a>
                    </div>
                </footer>
            </article>

        </div>
    </div>
@endsection