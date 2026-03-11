@extends('layouts.app')
@section('title', ($page->meta_title ?: $page->title) . ' - DigtafWare')
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))

@section('header', $page->title)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-8">
                {{ $page->title }}
            </h1>

            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                {!! $page->content !!}
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                    Last updated: {{ $page->updated_at->format('F d, Y') }}
                </p>
            </div>
        </div>
    </div>
@endsection