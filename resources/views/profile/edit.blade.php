@extends('layouts.app')

@section('title', 'Profile Settings - DigtafWare')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Profile Settings</h1>
                <p class="mt-2 text-lg text-gray-500 dark:text-gray-400">Manage your account information, security, and
                    preferences.</p>
            </div>

            <div class="space-y-8">
                <!-- Profile Information -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 sm:p-10">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Update Password -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 sm:p-10">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Danger Zone: Delete Account -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-red-100 dark:border-red-900/30 overflow-hidden">
                    <div class="bg-red-50 dark:bg-red-900/10 px-6 py-4 border-b border-red-100 dark:border-red-900/30">
                        <h3 class="text-lg font-bold text-red-700 dark:text-red-400">Danger Zone</h3>
                    </div>
                    <div class="p-6 sm:p-10">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection