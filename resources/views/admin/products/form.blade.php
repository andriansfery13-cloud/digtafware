@extends('layouts.admin')

@section('header', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
            Products</a>
    </div>

    <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Main Details -->
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-6">

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product
                                Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required
                                value="{{ old('title', $product->title ?? '') }}"
                                class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2">
                            @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="category_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category <span
                                        class="text-red-500">*</span></label>
                                <select id="category_id" name="category_id" required
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select Category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                </p> @enderror
                            </div>

                            <div>
                                <label for="version"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Initial
                                    Version</label>
                                <input type="text" name="version" id="version" value="{{ old('version', '1.0.0') }}"
                                    class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                                    placeholder="e.g. 1.0.0">
                                @error('version') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description <span
                                    class="text-red-500">*</span></label>
                            <!-- In a real app we'd integrate Trix or TinyMCE here -->
                            <textarea id="description" name="description" rows="5" required
                                class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="features"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Features List (HTML
                                allowed)</label>
                            <textarea id="features" name="features" rows="4"
                                class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2">{{ old('features', $product->features ?? '') }}</textarea>
                            @error('features') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="requirements"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Server/System
                                Requirements (HTML allowed)</label>
                            <textarea id="requirements" name="requirements" rows="3"
                                class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2">{{ old('requirements', $product->requirements ?? '') }}</textarea>
                            @error('requirements') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Media & Files</h3>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Main Source File -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Source File
                                    (.zip) {{ isset($product) ? '' : '<span class="text-red-500">*</span>' }}</label>
                                <input type="file" name="file" accept=".zip" {{ isset($product) ? '' : 'required' }}
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 border border-gray-300 dark:border-gray-600 rounded-md">
                                @if(isset($product) && $product->file_path)
                                    <p class="mt-2 text-xs text-green-600 dark:text-green-400">Current file uploaded. Upload new
                                        to replace.</p>
                                @endif
                                @error('file') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Thumbnail -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Thumbnail
                                    Image {{ isset($product) ? '' : '<span class="text-red-500">*</span>' }}</label>
                                <input type="file" name="thumbnail" accept="image/*" {{ isset($product) ? '' : 'required' }}
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 border border-gray-300 dark:border-gray-600 rounded-md">
                                @if(isset($product) && $product->thumbnail)
                                    <img src="{{ Storage::url($product->thumbnail) }}"
                                        class="mt-2 h-20 rounded border border-gray-200 dark:border-gray-700">
                                @endif
                                @error('thumbnail') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                </p> @enderror
                            </div>
                        </div>

                        <!-- Additional Screenshots -->
                        @if(!isset($product))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gallery
                                    Screenshots (Multiple)</label>
                                <input type="file" name="screenshots[]" multiple accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 border border-gray-300 dark:border-gray-600 rounded-md">
                                @error('screenshots.*') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                </p> @enderror
                            </div>
                        @else
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gallery management requires
                                    creating a separate ImageController in a fully baked app.</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Right Column: Pricing & Visibility -->
            <div class="lg:col-span-1 space-y-8">
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-24">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Pricing & Publishing</h3>
                    </div>
                    <div class="p-6 space-y-6">

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                                <span class="text-red-500">*</span></label>
                            <select id="status" name="status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="published" {{ old('status', $product->status ?? '') == 'published' ? 'selected' : '' }}>Published (Public)</option>
                                <option value="draft" {{ old('status', $product->status ?? '') == 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                                <option value="archived" {{ old('status', $product->status ?? '') == 'archived' ? 'selected' : '' }}>Archived (Hidden)</option>
                            </select>
                            @error('status') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price
                                (IDR) <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="price" id="price" required min="0"
                                    value="{{ old('price', $product->price ?? '0') }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                                    placeholder="0">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Set 0 for free products.</p>
                            @error('price') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_enterprise" name="is_enterprise" type="checkbox" value="1" {{ old('is_enterprise', $product->is_enterprise ?? false) ? 'checked' : '' }}
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_enterprise" class="font-medium text-gray-700 dark:text-gray-300">Enterprise
                                    Product</label>
                                <p class="text-gray-500 dark:text-gray-400">If checked, hides price and button says "Contact
                                    Us".</p>
                            </div>
                        </div>

                        <hr class="border-gray-200 dark:border-gray-700">

                        <div>
                            <label for="demo_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Live
                                Demo URL</label>
                            <input type="url" name="demo_url" id="demo_url"
                                value="{{ old('demo_url', $product->demo_url ?? '') }}"
                                class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                                placeholder="https://demo.example.com">
                            @error('demo_url') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors mt-6">
                            {{ isset($product) ? 'Save Changes' : 'Publish Product' }}
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection