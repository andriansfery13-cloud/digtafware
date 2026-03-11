<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create an account</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Join our community of digital creators.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="dark:text-gray-300" />
            <x-text-input id="name" class="block mt-1 w-full dark:bg-slate-900/50" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-slate-900/50" type="email" name="email"
                :value="old('email')" required autocomplete="username" placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full dark:bg-slate-900/50" type="password" name="password"
                required autocomplete="new-password" placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-slate-900/50" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button
                class="w-full justify-center py-3 text-sm font-bold uppercase tracking-widest bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 shadow-lg shadow-emerald-500/20">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
            Already have an account?
            <a href="{{ route('login') }}"
                class="font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500">Sign in</a>
        </p>
    </form>
</x-guest-layout>