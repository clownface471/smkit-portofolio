<x-guest-layout :fullWidth="true">
    <div class="bg-white dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 py-24 sm:py-32">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-12">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Galeri Portofolio</h1>
                <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">Jelajahi semua karya inovatif yang telah dipublikasikan oleh para siswa.</p>
            </div>

            {{-- ====================================================== --}}
            {{-- KODE BARU DIMULAI DI SINI --}}
            {{-- ====================================================== --}}
            <form action="{{ route('portofolio.gallery') }}" method="GET" class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Search Input --}}
                    <div class="md:col-span-2">
                        <label for="search" class="sr-only">Cari Portofolio</label>
                        <input type="text" name="search" id="search" placeholder="Cari berdasarkan judul atau nama siswa..."
                            value="{{ request('search') }}"
                            class="w-full rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring-green-500 focus:border-green-500 dark:text-gray-300">
                    </div>
                    
                    {{-- Jurusan Filter --}}
                    <div>
                        <label for="jurusan" class="sr-only">Filter Jurusan</label>
                        <select name="jurusan" id="jurusan"
                                class="w-full rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring-green-500 focus:border-green-500 dark:text-gray-300"
                                onchange="this.form.submit()">
                            <option value="">Semua Jurusan</option>
                            <option value="RPL" @selected(request('jurusan') == 'RPL')>Rekayasa Perangkat Lunak</option>
                            <option value="DKV" @selected(request('jurusan') == 'DKV')>Desain Komunikasi Visual</option>
                        </select>
                    </div>
                </div>
            </form>
            {{-- ====================================================== --}}
            {{-- KODE BARU SELESAI DI SINI --}}
            {{-- ====================================================== --}}

            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($projects as $project)
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
                            <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
                                {{-- PERUBAHAN DI SINI --}}
                                <a href="{{ route('siswa.show', $project->user) }}" class="mr-2 relative z-10 hover:underline">
                                    {{ $project->user->name }}
                                </a>
                                {{-- AKHIR PERUBAHAN --}}
                                <div class="flex items-center gap-x-2">
                                    <span class="font-medium bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md px-1.5 py-0.5">{{ $project->user->jurusan }}</span>
                                </div>
                            </div>
                    </article>
                @empty
                    {{-- Pesan yang lebih baik ketika tidak ada hasil --}}
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada proyek yang cocok dengan pencarian Anda.</p>
                        <p class="text-gray-400 dark:text-gray-500 mt-2">Coba ganti kata kunci atau reset filter.</p>
                        <a href="{{ route('portofolio.gallery') }}" class="mt-4 inline-block text-sm text-green-600 dark:text-green-500 hover:underline">Reset Pencarian & Filter</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>