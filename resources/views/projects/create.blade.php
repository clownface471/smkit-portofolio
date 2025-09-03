    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Proyek Baru') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="POST" action="{{ route('projects.store') }}">
                            @csrf

                            <!-- Judul -->
                            <div>
                                <x-input-label for="title" :value="__('Judul Proyek')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Deskripsi -->
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Deskripsi Singkat')" />
                                <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- URL GitHub -->
                            <div class="mt-4">
                                <x-input-label for="github_url" :value="__('URL GitHub (Opsional)')" />
                                <x-text-input id="github_url" class="block mt-1 w-full" type="url" name="github_url" :value="old('github_url')" />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>

                             <!-- URL Demo -->
                             <div class="mt-4">
                                <x-input-label for="demo_url" :value="__('URL Demo / Website (Opsional)')" />
                                <x-text-input id="demo_url" class="block mt-1 w-full" type="url" name="demo_url" :value="old('demo_url')" />
                                <x-input-error :messages="$errors->get('demo_url')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Simpan Proyek') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
