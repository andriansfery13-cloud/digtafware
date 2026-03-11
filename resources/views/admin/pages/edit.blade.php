@extends('layouts.admin')

@section('header', isset($page) ? 'Edit Page' : 'New Page')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.pages.index') }}"
                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Pages
            </a>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                {{ isset($page) ? 'Edit Page: ' . $page->title : 'Create New Page' }}</h2>
        </div>

        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}"
                method="POST" class="p-6">
                @csrf
                @if(isset($page))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Page
                            Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $page->title ?? '') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            onkeyup="document.getElementById('slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '')">
                        @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                        <div class="flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-500 sm:text-sm">/p/</span>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug ?? '') }}" required
                                class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Content
                            (HTML or Markdown supported)</label>
                        <textarea name="content" id="content" rows="15" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content', $page->content ?? '') }}</textarea>
                        @error('content') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">SEO Settings</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="meta_title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta
                                    Title</label>
                                <input type="text" name="meta_title" id="meta_title"
                                    value="{{ old('meta_title', $page->meta_title ?? '') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('meta_title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="meta_description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta
                                    Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                                @error('meta_description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Active /
                            Published</label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ isset($page) ? 'Update Page' : 'Create Page' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection