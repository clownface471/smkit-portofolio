@props(['project'])

<div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-1 group flex flex-col h-full">
    <a href="{{ route('portofolio.show', $project) }}" class="flex flex-col flex-grow">
        {{-- Gambar Thumbnail dengan Tinggi Konsisten dan Efek Zoom --}}
        <div class="relative h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
            @php
                $thumbnail = $project->media->firstWhere('file_type', 'image');
            @endphp
            
            @if ($thumbnail)
                <img class="w-full h-full object-cover transition-transform duration-300 ease-in-out group-hover:scale-110" src="{{ $thumbnail->file_url }}" alt="{{ $project->title }}">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif
        </div>

        {{-- Detail Konten --}}
        <div class="p-4 flex-grow flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate" title="{{ $project->title }}">
                {{ $project->title }}
            </h3>
            <div class="mt-1 flex items-center text-sm text-gray-600 dark:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <span>{{ $project->user->name }}</span>
            </div>
        </div>
    </a>
</div>

