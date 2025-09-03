<x-guest-layout :fullWidth="true">
    <div class="bg-white dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 py-24 sm:py-32">
            <!-- Header Halaman -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-12">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Galeri Portofolio</h1>
                <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">Jelajahi semua karya inovatif yang telah dipublikasikan oleh para siswa.</p>
            </div>

            <!-- Filter (Coming Soon) -->
            <div class="mb-8 p-4 bg-gray-100 dark:bg-gray-900/50 rounded-lg">
                 <h3 class="font-semibold text-gray-900 dark:text-white">Filter Karya</h3>
                 <p class="text-sm text-gray-500 dark:text-gray-400">Fitur filter berdasarkan jurusan dan keahlian akan segera hadir.</p>
            </div>

            <!-- Grid Proyek -->
            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($projects as $project)
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
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada proyek yang dipublikasikan.</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>

            <!-- Paginasi -->
            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>
