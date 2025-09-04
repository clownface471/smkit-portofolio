<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pratinjau Proyek: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Inisialisasi Alpine.js untuk Lightbox --}}
            <div x-data="{ lightboxOpen: false, lightboxSrc: '' }" class="min-h-screen"> {{-- Tambahkan min-h-screen di sini --}}
                <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-sm">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">

                        <div class="mb-8">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                                </svg>
                                Kembali ke Dashboard
                            </a>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-12 gap-y-10">

                            {{-- Kolom Kiri: Detail Proyek (Sticky) --}}
                            <div class="lg:col-span-1 lg:sticky lg:top-8 self-start max-h-[calc(100vh-10rem)] overflow-y-auto pr-2"> {{-- Penyesuaian sticky, max-h, dan overflow --}}
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                                    <p class="text-base font-semibold leading-7 text-assyifa-600 dark:text-assyifa-500">{{ $project->user->jurusan }}</p>
                                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl break-words"> {{-- Tambah break-words --}}
                                        {{ $project->title }}
                                    </h1>
                                    <p class="mt-4 text-base text-gray-600 dark:text-gray-300">
                                        Oleh
                                        <a href="#" class="font-semibold text-assyifa-600 dark:text-assyifa-500">
                                            {{ $project->user->name }}
                                        </a>
                                    </p>

                                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tentang Proyek</h2>
                                        <div class="mt-2 prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 break-words"> {{-- Tambah break-words --}}
                                            {!! nl2br(e($project->description)) !!}
                                        </div>
                                    </div>

                                    @if($project->github_url || $project->demo_url || $project->embed_url || $project->source_url)
                                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tautan & Sumber</h3>
                                            <div class="mt-4 flex flex-col space-y-3">
                                                @if($project->demo_url)<a href="{{ $project->demo_url }}" target="_blank" class="font-medium text-assyifa-600 dark:text-assyifa-500 hover:underline">Lihat Demo Live</a>@endif
                                                @if($project->github_url)<a href="{{ $project->github_url }}" target="_blank" class="font-medium text-gray-600 dark:text-gray-400 hover:underline">Lihat di GitHub</a>@endif
                                                @if($project->embed_url)<a href="{{ $project->embed_url }}" target="_blank" class="font-medium text-gray-600 dark:text-gray-400 hover:underline">Tautan Interaktif</a>@endif
                                                @if($project->source_url)<a href="{{ $project->source_url }}" target="_blank" class="font-medium text-gray-600 dark:text-gray-400 hover:underline">Download File Mentah</a>@endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($project->tags->isNotEmpty())
                                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Teknologi & Kategori</h3>
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @foreach($project->tags as $tag)
                                                    <span class="inline-block rounded-full bg-gray-100 dark:bg-gray-700 px-3 py-1 text-sm font-medium text-gray-700 dark:text-gray-200">{{ $tag->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Kolom Kanan: Media Proyek --}}
                            <div class="lg:col-span-2 space-y-6">
                                @forelse($project->media->sortBy('sort_order') as $media)
                                    <div class="break-inside-avoid">
                                        @if($media->file_type === 'image')
                                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="Gambar proyek"
                                                 class="rounded-lg shadow-lg w-full h-auto object-cover cursor-pointer transition-transform hover:scale-[1.02]"
                                                 @click="lightboxOpen = true; lightboxSrc = '{{ asset('storage/' . $media->file_path) }}'">
                                        @elseif($media->file_type === 'video_upload')
                                            <video controls class="rounded-lg shadow-lg w-full"><source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4"></video>
                                        @elseif($media->file_type === 'video_embed' && filter_var($media->embed_url, FILTER_VALIDATE_URL))
                                            @php
                                                $embedUrl = $media->embed_url;
                                                if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                                                    $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                                                } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                                    $videoId = last(explode('/', $embedUrl));
                                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                                }
                                            @endphp
                                            <div class="aspect-video w-full">
                                                <iframe src="{{ $embedUrl }}" class="rounded-lg shadow-lg w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="aspect-video w-full rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center shadow-lg">
                                        <span class="text-gray-500">Media tidak tersedia untuk proyek ini.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lightbox/Modal --}}
                <div x-show="lightboxOpen" x-transition @click.self="lightboxOpen = false" @keydown.escape.window="lightboxOpen = false" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50" x-cloak>
                    <div class="relative"><button @click="lightboxOpen = false" class="absolute -top-10 right-0 text-white text-3xl">&times;</button><div class="bg-white dark:bg-black rounded-lg overflow-hidden"><img :src="lightboxSrc" alt="Tampilan Penuh" class="max-w-screen-lg max-h-[85vh] object-contain"></div></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>