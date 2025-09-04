<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <input id="password"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-assyifa-500 dark:focus:border-assyifa-600 focus:ring-assyifa-500 dark:focus:ring-assyifa-600 rounded-md shadow-sm block mt-1 w-full pr-10"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    required autocomplete="current-password" />

                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button" @click="showPassword = !showPassword" class="text-gray-500 dark:text-gray-400 focus:outline-none">
                        {{-- Ikon Mata Terbuka --}}
                        <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.18l.88-1.464a1.651 1.651 0 011.698-.823l13.233 2.206a1.651 1.651 0 011.132 2.25l-.88 1.464a1.651 1.651 0 01-1.698.823L2.493 11.413a1.651 1.651 0 01-1.132-2.25L.664 10.59zM10 15a5 5 0 100-10 5 5 0 000 10z" clip-rule="evenodd" />
                        </svg>
                        {{-- Ikon Mata Tercoret --}}
                        <svg x-show="showPassword" x-cloak class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38c-1.543-3.957-5.166-7-9.56-7a9.963 9.963 0 00-4.612 1.075L3.28 2.22zM7.5 10a2.5 2.5 0 005 0 2.5 2.5 0 00-5 0z" clip-rule="evenodd" />
                            <path d="M9.91 12.126a3.501 3.501 0 01-4.43 4.43l.22-.22a3.5 3.5 0 014.21-4.21l.22.22zM9.91 7.874c.394-.393.835-.734 1.313-.992a3.5 3.5 0 00-4.21 4.21c.258.478.599.919.992 1.313l.22-.22a3.5 3.5 0 004.21-4.21l-.22-.22z" />
                            <path d="M10 3a7 7 0 00-7 7c0 1.554.444 3.012 1.228 4.286l.22-.22a3.5 3.5 0 014.21-4.21l.22-.22A6.963 6.963 0 0010 3z" />
                        </svg>
                    </button>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-assyifa-600 shadow-sm focus:ring-assyifa-500 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-assyifa-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>