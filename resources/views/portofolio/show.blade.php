<x-guest-layout :fullWidth="true">
    {{-- Inisialisasi Alpine.js untuk Lightbox --}}
    <div x-data="{ lightboxOpen: false, lightboxSrc: '', isImage: true }">
        <div class="bg-white dark:bg-gray-900">
            <div class="mx-auto max-w-7xl px-6 lg:px-8 py-16 sm:py-24">
                <!-- Header -->
                <div class="max-w-4xl mx-auto mb-16">
                    <p class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">{{ $project->user->jurusan }}</p>
                    <h1 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">{{ $project->title }}</h1>
                    <p class="mt-6 text-xl leading-8 text-gray-600 dark:text-gray-300">
                        Sebuah karya oleh <span class="font-bold text-gray-800 dark:text-gray-100">{{ $project->user->name }}</span>
                    </p>
                </div>

                <!-- Konten Utama: Layout Dua Kolom -->
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-x-12 gap-y-10">
                    
                    <!-- Kolom Kiri (Deskripsi & Tautan) - dibuat "lengket" di layar besar -->
                    <div class="lg:col-span-1 lg:sticky lg:top-24 self-start">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tentang Proyek</h2>
                        <div class="mt-4 prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400">
                            {!! nl2br(e($project->description)) !!}
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-10">Tautan & Sumber</h3>
                        <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4 flex flex-col space-y-3">
                             @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Lihat di GitHub</a>
                            @endif
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Demo Live</a>
                            @endif
                            @if($project->embed_url)
                                 <a href="{{ $project->embed_url }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Tautan Interaktif (Figma, dll)</a>
                            @endif
                            @if($project->source_url)
                                 <a href="{{ $project->source_url }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Download File Mentah</a>
                            @endif
                        </div>
                    </div>

                    <!-- Kolom Kanan (Galeri Media) -->
                    <div class="lg:col-span-2 space-y-8">
                        @php
                            // Urutkan media: Video embed dulu, lalu gambar, lalu video upload
                            $sortedMedia = $project->media->sortBy(function ($media) {
                                if ($media->file_type === 'video_embed') return 1;
                                if ($media->file_type === 'image') return 2;
                                return 3;
                            });
                        @endphp

                        @forelse($sortedMedia as $media)
                            <div class="break-inside-avoid">
                                @if($media->file_type === 'image')
                                    <img src="{{ asset('storage/' . $media->file_path) }}" alt="Gambar proyek" 
                                         class="rounded-2xl shadow-xl w-full h-auto object-cover cursor-pointer"
                                         @click="lightboxOpen = true; lightboxSrc = '{{ asset('storage/' . $media->file_path) }}'; isImage = true">
                                @elseif($media->file_type === 'video_upload')
                                    <video controls class="rounded-2xl shadow-xl w-full">
                                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                    </video>
                                @elseif($media->file_type === 'video_embed' && filter_var($media->embed_url, FILTER_VALIDATE_URL))
                                    @php
                                        // Logika embed URL tidak berubah
                                        $embedUrl = $media->embed_url;
                                        if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                                            $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                                        } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                            $videoId = last(explode('/', $embedUrl));
                                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                        }
                                    @endphp
                                    <div class="aspect-video w-full">
                                        <iframe src="{{ $embedUrl }}" class="rounded-2xl shadow-xl w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="aspect-video w-full rounded-2xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-500">Media tidak tersedia untuk proyek ini.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Lightbox/Modal (Tidak Berubah) --}}
        <div x-show="lightboxOpen" x-transition @click.self="lightboxOpen = false" @keydown.escape.window="lightboxOpen = false" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50" x-cloak>
            <div class="relative">
                <button @click="lightboxOpen = false" class="absolute -top-10 right-0 text-white text-3xl">&times;</button>
                <div class="bg-white dark:bg-black rounded-lg overflow-hidden">
                    <template x-if="isImage">
                        <img :src="lightboxSrc" alt="Tampilan Penuh" class="max-w-screen-lg max-h-[85vh] object-contain">
                    </template>
                    <template x-if="!isImage">
                        <video :src="lightboxSrc" controls autoplay class="max-w-screen-lg max-h-[85vh]"></video>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>