    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ config('app.name', 'Laravel') }}</title>

            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
        <body class="font-sans text-gray-900 antialiased">
            <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
                <!-- Header Navigasi Publik -->
                <header class="bg-white dark:bg-gray-800 shadow-md" x-data="{ open: false }">
                    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
                        <div class="flex lg:flex-1">
                            <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                                <span class="sr-only">SMK-IT As-Syifa</span>
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </a>
                        </div>
                        <div class="flex lg:hidden">
                            <button type="button" @click="open = !open" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 dark:text-gray-300">
                                <span class="sr-only">Open main menu</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="hidden lg:flex lg:gap-x-12">
                            <a href="{{ route('home') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Beranda</a>
                            <a href="{{ route('portofolio.gallery') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Galeri Portofolio</a>
                        </div>
                        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                            @auth
                                 <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Dashboard <span aria-hidden="true">&rarr;</span></a>
                            @else
                                @if (!request()->routeIs('login'))
                                    <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Log in <span aria-hidden="true">&rarr;</span></a>
                                @endif
                            @endauth
                        </div>
                    </nav>
                     <!-- Mobile menu -->
                    <div x-show="open" class="lg:hidden" x-transition>
                        <div class="space-y-1 px-2 pb-3 pt-2">
                            <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-white">Beranda</a>
                            <a href="{{ route('portofolio.gallery') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-white">Galeri Portofolio</a>
                             @auth
                                 <a href="{{ url('/dashboard') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-white">Dashboard</a>
                            @else
                                @if (!request()->routeIs('login'))
                                    <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 dark:text-white">Log in</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </header>
                
                <!-- **PERBAIKAN UTAMA DI SINI** -->
                <!-- Tag 'main' sekarang dinamis -->
                <main @class([
                    'flex-grow',
                    'flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4' => !$fullWidth,
                ])>
                    {{ $slot }}
                </main>
            </div>
        </body>
    </html>
    

