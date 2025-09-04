<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Proyek: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        isRpl: {{ $project->user->jurusan === 'RPL' ? 'true' : 'false' }},
        isDkv: {{ $project->user->jurusan === 'DKV' ? 'true' : 'false' }},
        videoChoice: '{{ $project->media->firstWhere('file_type', 'like', 'video_%') ? ($project->media->firstWhere('file_type', 'like', 'video_%')->file_type == 'video_upload' ? 'upload' : 'embed') : 'none' }}'
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="title" :value="__('Judul Proyek')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $project->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi Proyek')" />
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            @include('projects.partials._tags-selection')
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        @if($project->media->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Media Saat Ini</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Centang kotak untuk menghapus media saat menyimpan perubahan.</p>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($project->media as $media)
                                    <div class="relative group">
                                        @if($media->file_type === 'image')
                                            <img src="{{ asset('storage/' . $media->file_path) }}" class="rounded-lg object-cover w-full h-32">
                                        @elseif($media->file_type === 'video_upload')
                                            <div class="w-full h-32 bg-black rounded-lg flex items-center justify-center text-white text-4xl" title="{{ $media->file_name }}">&#9658;</div>
                                        @elseif($media->file_type === 'video_embed')
                                             <div class="w-full h-32 bg-red-800 rounded-lg flex items-center justify-center text-white text-center text-xs p-2" title="{{ $media->embed_url }}">LINK YOUTUBE</div>
                                        @endif
                                        <div class="absolute top-1 right-1">
                                            <label class="flex items-center space-x-2 bg-white/80 dark:bg-black/80 p-1 rounded-full cursor-pointer">
                                                <input type="checkbox" name="delete_media[]" value="{{ $media->id }}" class="rounded-full text-red-500 focus:ring-red-500 dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                                <span class="text-xs text-red-700 dark:text-red-300 font-bold hidden sm:inline">Hapus</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($errors->has('delete_media.*'))
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1">
                                    @foreach($errors->get('delete_media.*') as $messages)
                                        @foreach($messages as $message)
                                            <p>{{ $message }}</p>
                                        @endforeach
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        @endif

                        <div x-show="isRpl" x-transition>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Link Proyek (RPL)</h3>
                            <div class="mt-4">
                                <x-input-label for="github_url" :value="__('URL GitHub (Wajib)')" />
                                <x-text-input id="github_url" class="block mt-1 w-full" type="url" name="github_url" :value="old('github_url', $project->github_url)" />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="demo_url" :value="__('URL Demo (Opsional)')" />
                                <x-text-input id="demo_url" class="block mt-1 w-full" type="url" name="demo_url" :value="old('demo_url', $project->demo_url)" />
                                <x-input-error :messages="$errors->get('demo_url')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tambah Media Visual Baru</h3>
                            <div class="mt-4">
                                <x-input-label for="images" :value="__('Upload Gambar Baru (Bisa lebih dari satu)')" />
                                <input id="images" name="images[]" type="file" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-2">
                                @if ($errors->has('images.*'))
                                    <div class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1">
                                        @foreach($errors->get('images.*') as $messages)
                                            @foreach($messages as $message)
                                                <p>{{ $message }}</p>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if(!$project->media->firstWhere('file_type', 'like', 'video_%'))
                            <div class="mt-4">
                                <x-input-label :value="__('Tambahkan Video? (Opsional, akan menggantikan video lama jika ada)')" />
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
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Embed Link</span>
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
                            @endif
                        </div>
                        
                        <div x-show="isDkv" x-transition>
                             <hr class="my-6 border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Link Tambahan (DKV)</h3>
                             <div class="mt-4">
                                <x-input-label for="embed_url" :value="__('Link Interaktif (Figma, Sketchfab, dll)')" />
                                <x-text-input id="embed_url" class="block mt-1 w-full" type="url" name="embed_url" :value="old('embed_url', $project->embed_url)" />
                                 <x-input-error :messages="$errors->get('embed_url')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="source_url" :value="__('Link File Mentah (Google Drive, dll)')" />
                                <x-text-input id="source_url" class="block mt-1 w-full" type="url" name="source_url" :value="old('source_url', $project->source_url)" />
                                 <x-input-error :messages="$errors->get('source_url')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Perbarui Proyek') }}
                            </x-primary-button>
                        </div>
                    </form>
                    @include('projects.partials.comments-section')
                </div>
            </div>
        </div>
    </x-app-layout>