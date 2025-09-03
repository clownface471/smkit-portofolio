<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Preview: {{ $project->title }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling dasar tidak berubah */
        body { background-color: #f3f4f6; color: #1f2937; }
        .dark body { background-color: #111827; color: #f9fafb; }
        .preview-container { max-width: 900px; margin: 40px auto; padding: 40px; background-color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .dark .preview-container { background-color: #1f2937; }
        .preview-header { border-bottom: 1px solid #e5e7eb; padding-bottom: 20px; margin-bottom: 20px; }
        .dark .preview-header { border-color: #374151; }
        .preview-title { font-size: 2.25rem; font-weight: bold; }
        .preview-author { font-size: 1.125rem; color: #4b5563; }
        .dark .preview-author { color: #9ca3af; }
        .preview-section-title { font-size: 1.5rem; font-weight: 600; margin-top: 30px; margin-bottom: 15px; }
        .preview-description p { line-height: 1.6; color: #374151; }
        .dark .preview-description p { color: #d1d5db; }
        .preview-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        .preview-gallery img, .preview-gallery .video-thumb { width: 100%; height: 150px; border-radius: 8px; object-fit: cover; cursor: pointer; transition: transform 0.2s; }
        .preview-gallery img:hover, .preview-gallery .video-thumb:hover { transform: scale(1.05); }
        .preview-link { display: inline-block; margin-top: 10px; margin-right: 10px; padding: 8px 16px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 6px; transition: background-color 0.3s; font-size: 0.875rem; }
        .preview-link:hover { background-color: #4338ca; }
        .embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; background: #000; border-radius: 8px; }
        .embed-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        .video-thumb { position: relative; display: flex; align-items: center; justify-content: center; background-color: #000; }
        .video-thumb .play-icon { font-size: 3rem; color: white; opacity: 0.8; }
    </style>
</head>
<body class="font-sans antialiased">
    {{-- Inisialisasi Alpine.js untuk mengontrol lightbox --}}
    <div x-data="{ lightboxOpen: false, lightboxSrc: '', isImage: true }">
        <div class="preview-container">
            <div class="text-center bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300 p-3 rounded-md mb-6">
                <strong>Ini adalah Halaman Preview.</strong> Tampilan ini meniru bagaimana proyek Anda akan terlihat oleh publik.
                <a href="{{ url()->previous() }}" class="font-bold underline ml-4">Kembali</a>
            </div>

            <header class="preview-header">
                <h1 class="preview-title">{{ $project->title }}</h1>
                <p class="preview-author">Oleh: {{ $project->user->name }} ({{ $project->user->jurusan }})</p>
            </header>

            <main>
                <section class="preview-description">
                    <h2 class="preview-section-title">Deskripsi Proyek</h2>
                    <div class="prose dark:prose-invert max-w-none">{!! nl2br(e($project->description)) !!}</div>
                </section>

                @if($project->media->isNotEmpty())
                <section class="preview-media">
                    <h2 class="preview-section-title">Galeri & Media</h2>
                    {{-- **PERBAIKAN DI SINI:** Kedua loop sekarang ada di dalam satu div galeri --}}
                    <div class="preview-gallery">
                        {{-- Loop untuk gambar dan video yang di-upload --}}
                        @foreach($project->media->whereIn('file_type', ['image', 'video_upload']) as $media)
                            @if($media->file_type === 'image')
                                <img src="{{ asset('storage/' . $media->file_path) }}" alt="Gambar proyek"
                                     @click="lightboxOpen = true; lightboxSrc = '{{ asset('storage/' . $media->file_path) }}'; isImage = true">
                            @elseif($media->file_type === 'video_upload')
                                <div class="video-thumb" @click="lightboxOpen = true; lightboxSrc = '{{ asset('storage/' . $media->file_path) }}'; isImage = false">
                                    <span class="play-icon">&#9658;</span>
                                </div>
                            @endif
                        @endforeach

                        {{-- Loop untuk video YouTube/Vimeo yang di-embed --}}
                        @foreach($project->media->where('file_type', 'video_embed') as $media)
                            @if(filter_var($media->embed_url, FILTER_VALIDATE_URL))
                                @php
                                    $embedUrl = $media->embed_url;
                                    if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                                        $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                                    } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                        $videoId = last(explode('/', $embedUrl));
                                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                    }
                                @endphp
                                 <div class="embed-container">
                                    <iframe src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
                @endif

                <section class="preview-links">
                    {{-- ... (bagian tautan tidak berubah) ... --}}
                    <h2 class="preview-section-title">Tautan & Sumber</h2>
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="preview-link">Lihat di GitHub</a>
                    @endif
                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" class="preview-link">Lihat Demo Live</a>
                    @endif
                    @if($project->embed_url)
                         <a href="{{ $project->embed_url }}" target="_blank" class="preview-link">Tautan Interaktif (Figma, dll)</a>
                    @endif
                    @if($project->source_url)
                         <a href="{{ $project->source_url }}" target="_blank" class="preview-link">Download File Mentah</a>
                    @endif
                </section>
            </main>
        </div>

        {{-- Lightbox/Modal tidak berubah --}}
        <div x-show="lightboxOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="lightboxOpen = false"
             @keydown.escape.window="lightboxOpen = false"
             class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50"
             x-cloak>
            
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
</body>
</html>

