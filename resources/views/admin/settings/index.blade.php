<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Situs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <!-- Hero Title -->
                            <div>
                                <x-input-label for="hero_title" :value="__('Judul Utama (Homepage)')" />
                                <x-text-input id="hero_title" name="hero_title" type="text" class="mt-1 block w-full" :value="old('hero_title', $settings['hero_title'] ?? 'Portofolio Karya Siswa')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hero_title')" />
                            </div>

                            <!-- Hero Subtitle -->
                            <div>
                                <x-input-label for="hero_subtitle" :value="__('Subjudul/Deskripsi (Homepage)')" />
                                <textarea id="hero_subtitle" name="hero_subtitle" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3" required>{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Menampilkan talenta dan inovasi dari siswa-siswi berprestasi SMK-IT As-Syifa Boarding School.') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('hero_subtitle')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Simpan Pengaturan') }}</x-primary-button>
            
                            @if (session('success'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 3000)"
                                    class="text-sm text-green-600 dark:text-green-400"
                                >{{ session('success') }}</p>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
