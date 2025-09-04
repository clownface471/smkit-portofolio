<x-guest-layout :fullWidth="true">
    <div class="bg-white dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 py-24 sm:py-32">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-12">
                <div class="mb-8">
                    <a href="{{ route('portofolio.gallery') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        &larr; Kembali ke Galeri Utama
                    </a>
                </div>
                {{-- Informasi Siswa --}}
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    Portofolio Milik: {{ $user->name }}
                </h1>
                <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Siswa Jurusan <span class="font-semibold text-green-600 dark:text-green-500">{{ $user->jurusan }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($user->projects as $project)
                    {{-- Kartu Proyek (Sama seperti di halaman galeri) --}}
                    <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80 group">
                        <img src="{{ $project->media->firstWhere('file_type', 'image') ? asset('storage/' . $project->media->firstWhere('file_type', 'image')->file_path) : 'https://placehold.co/600x400/004D40/FFFFFF?text=Project' }}" alt="Gambar Proyek" class="absolute inset-0 -z-10 h-full w-full object-cover transition-transform duration-300 ease-in-out group-hover:scale-105">
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900/80 via-gray-900/40"></div>
                        <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>

                        <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                            <a href="{{ route('portofolio.show', $project) }}">
                                <span class="absolute inset-0"></span>
                                {{ $project->title }}
                            </a>
                        </h3>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">
                            {{ $user->name }} belum mempublikasikan proyek apapun.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-guest-layout>