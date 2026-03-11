@extends('layouts.admin')

@section('header', 'Blogs Management')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Blog Posts</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Write articles, tutorials, and announcements.</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}"
            class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Write Post
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 dark:bg-green-900/40 p-4 border border-green-200 dark:border-green-800">
            <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Article</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Published Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-16 flex-shrink-0 rounded-md bg-gray-100 dark:bg-gray-700 overflow-hidden border border-gray-200 dark:border-gray-600">
                                        @if($blog->thumbnail)
                                            <img src="{{ Storage::url($blog->thumbnail) }}" alt=""
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4 flex flex-col">
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1 truncate max-w-[300px]">{{ $blog->title }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">By
                                            {{ $blog->author->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($blog->status == 'published')
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">
                                        Published
                                    </span>
                                @else
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $blog->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3 items-center">
                                    {{-- <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank"
                                        class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">View</a>
                                    --}}
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this post?');">
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
                                <span class="block mt-2 font-medium">No blog posts found.</span>
                                <a href="{{ route('admin.blogs.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">Write your first post</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($blogs) && $blogs->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
@endsection