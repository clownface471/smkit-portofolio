<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status') === 'profile-updated')
                <div class="mb-4 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4" role="alert">
                    <p>Profil Anda berhasil diperbarui.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach ($navigationItems as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col">
                        <div class="flex-grow">
                            {{-- Tampilkan Ikon jika ada --}}
                            @if (isset($item['icon']))
                                <div class="mb-4">
                                    {!! $item['icon'] !!}
                                </div>
                            @endif
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $item['title'] }}</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $item['description'] }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <ul class="space-y-2">
                                {{-- Jika ada banyak link (untuk Admin) --}}
                                @if (isset($item['links']))
                                    @foreach ($item['links'] as $link)
                                        <li>
                                            <a href="{{ route($link['route']) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                                {{ $link['name'] }} →
                                            </a>
                                        </li>
                                    @endforeach
                                {{-- Jika hanya ada satu link (untuk Guru, Siswa & Profil) --}}
                                @else
                                    <li>
                                        <a href="{{ route($item['route']) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Buka {{ $item['title'] }} →
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>

