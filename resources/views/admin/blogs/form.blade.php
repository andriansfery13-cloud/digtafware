@extends('layouts.admin')

@section('header', isset($blog) ? 'Edit Post' : 'Write Post')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.blogs.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to Posts</a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden max-w-4xl">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                {{ isset($blog) ? 'Edit Post: ' . $blog->title : 'Write New Content' }}
            </h3>
        </div>

        <form action="{{ isset($blog) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}"
            method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @if(isset($blog))
                @method('PUT')
            @endif

            <div class="space-y-6">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title <span
                            class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="title" id="title" required value="{{ old('title', $blog->title ?? '') }}"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2">
                    </div>
                    @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content <span
                            class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <textarea id="content" name="content" rows="12" required
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                            placeholder="Write your post here (HTML allowed)">{{ old('content', $blog->content ?? '') }}</textarea>
                    </div>
                    @error('content') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured
                            Image</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 border border-gray-300 dark:border-gray-600 rounded-md">
                        @if(isset($blog) && $blog->thumbnail)
                            <img src="{{ Storage::url($blog->thumbnail) }}"
                                class="mt-2 h-32 rounded border border-gray-200 dark:border-gray-700 object-cover">
                        @endif
                        @error('thumbnail') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="draft" {{ old('status', $blog->status ?? '') == 'draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="published" {{ old('status', $blog->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>

            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-5 flex justify-end gap-3">
                <a href="{{ route('admin.blogs.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ isset($blog) ? 'Update Post' : 'Save Post' }}
                </button>
            </div>
        </form>
    </div>
@endsection