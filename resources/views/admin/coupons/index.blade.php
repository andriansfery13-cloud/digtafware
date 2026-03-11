@extends('layouts.admin')

@section('header', 'Coupons Management')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Discount Coupons</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage promotional codes for your marketplace.</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}"
            class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Coupon
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
                            Coupon Code</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Discount</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Usage</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status/Expiry</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 font-mono font-bold text-sm tracking-wider">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                @if($coupon->type == 'percent')
                                    {{ $coupon->value }}% Off
                                @else
                                    Rp {{ number_format($coupon->value, 0, ',', '.') }} Off
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }} uses
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($coupon->expires_at && $coupon->expires_at->isPast())
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400">Expired</span>
                                @elseif($coupon->max_uses && $coupon->used_count >= $coupon->max_uses)
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Depleted</span>
                                @else
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">Active</span>
                                @endif
                                @if($coupon->expires_at)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Exp:
                                        {{ $coupon->expires_at->format('M d, Y') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3 items-center">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this coupon?');">
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
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <span class="block mt-2 font-medium">No coupons found.</span>
                                <a href="{{ route('admin.coupons.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">Create a discount code</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($coupons) && $coupons->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
@endsection