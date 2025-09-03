<x-guest-layout :fullWidth="true">
    <div class="bg-gray-100 dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden bg-gray-900">
            <div class="px-6 lg:px-8 py-24 sm:py-32 lg:py-40">
                <div class="mx-auto max-w-2xl text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Portofolio Karya Siswa</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-300">Menampilkan talenta dan inovasi dari siswa-siswi berprestasi SMK-IT As-Syifa Boarding School.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('portofolio.gallery') }}" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400">Lihat Semua Karya</a>
                        <a href="#featured" class="text-sm font-semibold leading-6 text-white">Proyek Unggulan <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
             <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]" aria-hidden="true">
                <circle cx="512" cy="512" r="512" fill="url(#8d958450-c69f-4251-94bc-4e09d5c443b0)" fill-opacity="0.7" />
                <defs>
                    <radialGradient id="8d958450-c69f-4251-94bc-4e09d5c443b0">
                        <stop stop-color="#7775D6" />
                        <stop offset="1" stop-color="#E935C1" />
                    </radialGradient>
                </defs>
            </svg>
        </div>

        <!-- Featured Projects Section -->
        <div id="featured" class="bg-white dark:bg-gray-800 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Proyek Unggulan</h2>
                    <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">Beberapa karya terbaik yang telah diseleksi dan dipublikasikan.</p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @forelse ($featuredProjects as $project)
                        <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
                            <img src="{{ $project->media->firstWhere('file_type', 'image') ? asset('storage/' . $project->media->firstWhere('file_type', 'image')->file_path) : 'https://placehold.co/600x400/004D40/FFFFFF?text=Project' }}" alt="Gambar Proyek" class="absolute inset-0 -z-10 h-full w-full object-cover">
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                            <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>

                            <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                                <a href="{{ route('portofolio.show', $project) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
                               <span class="mr-2">{{ $project->user->name }}</span>
                               <div class="flex items-center gap-x-2">
                                   <span class="font-medium bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md px-1.5 py-0.5">{{ $project->user->jurusan }}</span>
                               </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-center col-span-3 text-gray-500 dark:text-gray-400">Belum ada proyek yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
