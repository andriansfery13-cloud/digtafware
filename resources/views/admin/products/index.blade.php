@extends('layouts.admin')

@section('header', 'Products Management')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Products</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage software, plugins, and templates listed on the
                marketplace.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Product
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 dark:bg-green-900/40 p-4 border border-green-200 dark:border-green-800">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters could be added here -->

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Product Info</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Price / Sales</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-16 flex-shrink-0 rounded-md bg-gray-100 dark:bg-gray-700 overflow-hidden border border-gray-200 dark:border-gray-600">
                                        @if($product->thumbnail)
                                            <img src="{{ Storage::url($product->thumbnail) }}" alt=""
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4 flex flex-col">
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1 max-w-[250px]">{{ $product->title }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $product->category->name }}
                                            &bull; v{{ $product->version ?? '1.0' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    @if($product->is_enterprise)
                                        <span class="text-indigo-600 dark:text-indigo-400">Enterprise</span>
                                    @elseif($product->price == 0)
                                        <span class="text-green-600 dark:text-green-400">Free</span>
                                    @else
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $product->download_count }} Sales
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->status == 'active')
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3 items-center">
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                        class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                                        title="View Public Page">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product? Files and screenshots will also be removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <span class="block text-sm font-medium mb-1">No products found.</span>
                                <a href="{{ route('admin.products.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">Create your first
                                    product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($products) && $products->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection