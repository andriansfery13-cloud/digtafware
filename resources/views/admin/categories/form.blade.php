@extends('layouts.admin')

@section('header', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
            Categories</a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden max-w-3xl">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                {{ isset($category) ? 'Edit Category: ' . $category->name : 'Create New Category' }}
            </h3>
        </div>

        <form
            action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
            method="POST" class="p-6">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="space-y-6">

                <!-- Target Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name <span
                            class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required value="{{ old('name', $category->name ?? '') }}"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                            placeholder="e.g. PHP Scripts">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                            placeholder="Brief description of this category">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon (SVG code) -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon (SVG
                        Code)</label>
                    <div class="mt-1">
                        <textarea id="icon" name="icon" rows="4"
                            class="font-mono text-xs shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                            placeholder="<svg class='w-6 h-6' ...></svg>">{{ old('icon', $category->icon ?? '') }}</textarea>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Paste raw SVG code here. Recommended size:
                        24x24 (w-6 h-6).</p>
                    @error('icon')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-5 flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    {{ isset($category) ? 'Update Category' : 'Create Category' }}
                </button>
            </div>
        </form>
    </div>
@endsection