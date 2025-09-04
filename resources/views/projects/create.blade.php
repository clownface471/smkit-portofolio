<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Proyek Baru') }} (Jurusan: {{ Auth::user()->jurusan }})
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        isRpl: {{ Auth::user()->jurusan === 'RPL' ? 'true' : 'false' }},
        isDkv: {{ Auth::user()->jurusan === 'DKV' ? 'true' : 'false' }},
        videoChoice: 'none'
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="title" :value="__('Judul Proyek')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi Proyek')" />
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-4">
                             @include('projects.partials._tags-selection')
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div x-show="isRpl" x-transition>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Link Proyek (RPL)</h3>
                            <div class="mt-4">
                                <x-input-label for="github_url" :value="__('URL GitHub (Wajib)')" />
                                <x-text-input id="github_url" class="block mt-1 w-full" type="url" name="github_url" :value="old('github_url')" />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="demo_url" :value="__('URL Demo (Opsional)')" />
                                <x-text-input id="demo_url" class="block mt-1 w-full" type="url" name="demo_url" :value="old('demo_url')" />
                            </div>
                        </div>

                        <div x-show="isDkv || isRpl">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Media Visual (Gambar & Video)</h3>
                            <div class="mt-4">
                                <x-input-label for="images" :value="__('Upload Gambar (Bisa lebih dari satu)')" />
                                <input id="images" name="images[]" type="file" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-2">
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label :value="__('Tambahkan Video? (Opsional)')" />
                                <div class="flex items-center space-x-4 mt-2">
                                    <label class="flex items-center">
                                        <input type="radio" x-model="videoChoice" name="video_type" value="none" class="dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-assyifa-600 shadow-sm focus:ring-assyifa-500 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Tidak Ada</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" x-model="videoChoice" name="video_type" value="upload" class="dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-assyifa-600 shadow-sm focus:ring-assyifa-500 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Upload File</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" x-model="videoChoice" name="video_type" value="embed" class="dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-assyifa-600 shadow-sm focus:ring-assyifa-500 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Embed Link (YouTube, dll)</span>
                                    </label>
                                </div>
                            </div>
                            <div x-show="videoChoice === 'upload'" class="mt-4" x-transition>
                                <x-input-label for="video_upload" :value="__('Upload File Video (Max: 20MB)')" />
                                <input id="video_upload" name="video_upload" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-2">
                                <x-input-error :messages="$errors->get('video_upload')" class="mt-2" />
                            </div>
                            <div x-show="videoChoice === 'embed'" class="mt-4" x-transition>
                                <x-input-label for="video_embed_url" :value="__('URL Video (YouTube, Vimeo, dll)')" />
                                <x-text-input id="video_embed_url" class="block mt-1 w-full" type="url" name="video_embed_url" :value="old('video_embed_url')" />
                                <x-input-error :messages="$errors->get('video_embed_url')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div x-show="isDkv" x-transition>
                             <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Link Interaktif & File Mentah (DKV)</h3>
                             <div class="mt-4">
                                 <x-input-label for="embed_url" :value="__('Link Interaktif (Figma, Sketchfab, dll)')" />
                                 <x-text-input id="embed_url" class="block mt-1 w-full" type="url" name="embed_url" :value="old('embed_url')" />
                                 <x-input-error :messages="$errors->get('embed_url')" class="mt-2" />
                             </div>
                             <div class="mt-4">
                                 <x-input-label for="source_url" :value="__('Link File Mentah (.psd, .ai, GDrive ZIP)')" />
                                 <x-text-input id="source_url" class="block mt-1 w-full" type="url" name="source_url" :value="old('source_url')" />
                                 <x-input-error :messages="$errors->get('source_url')" class="mt-2" />
                             </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan Proyek') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>