<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset password</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Please enter your new credentials below.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-slate-900/50" type="email" name="email"
                :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full dark:bg-slate-900/50" type="password" name="password"
                required autocomplete="new-password" placeholder="New password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-slate-900/50" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="Repeat new password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button
                class="w-full justify-center py-3 text-sm font-bold uppercase tracking-widest bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 shadow-lg shadow-emerald-500/20">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>