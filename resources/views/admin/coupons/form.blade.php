@extends('layouts.admin')

@section('header', isset($coupon) ? 'Edit Coupon' : 'Create Coupon')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.coupons.index') }}"
            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to
            Coupons</a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden max-w-3xl">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                {{ isset($coupon) ? 'Edit Coupon: ' . $coupon->code : 'Create New Discount Code' }}
            </h3>
        </div>

        <form action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}"
            method="POST" class="p-6">
            @csrf
            @if(isset($coupon))
                @method('PUT')
            @endif

            <div class="space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coupon Code
                            <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="code" id="code" required value="{{ old('code', $coupon->code ?? '') }}"
                                style="text-transform:uppercase"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 font-mono"
                                placeholder="e.g. SUMMER2024">
                        </div>
                        @error('code') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Type
                            <span class="text-red-500">*</span></label>
                        <select id="type" name="type"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="percent" {{ old('type', $coupon->type ?? '') == 'percent' ? 'selected' : '' }}>
                                Percentage (%)</option>
                            <option value="fixed" {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed
                                Amount (IDR)</option>
                        </select>
                        @error('type') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Value -->
                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Value
                            <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="number" name="value" id="value" required min="1" step="0.01"
                                value="{{ old('value', isset($coupon) ? (float) $coupon->value : '') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                                placeholder="e.g. 15 or 50000">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Number only. If percentage, enter value between 1-100.</p>
                        @error('value') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Max Uses -->
                    <div>
                        <label for="max_uses" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Usage Limit
                            (Max Uses)</label>
                        <div class="mt-1">
                            <input type="number" name="max_uses" id="max_uses" min="1"
                                value="{{ old('max_uses', $coupon->max_uses ?? '') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2"
                                placeholder="Leave empty for unlimited">
                        </div>
                        @error('max_uses') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Expiration -->
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiration
                        Date</label>
                    <div class="mt-1">
                        <input type="date" name="expires_at" id="expires_at"
                            value="{{ old('expires_at', isset($coupon) && $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Leave empty so the coupon never expires based on date.</p>
                    @error('expires_at') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-5 flex justify-end gap-3">
                <a href="{{ route('admin.coupons.index') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}
                </button>
            </div>
        </form>
    </div>
@endsection