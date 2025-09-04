<x-guest-layout :fullWidth="true">
    <div class="bg-white dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 py-24 sm:py-32">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-12">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Galeri Portofolio</h1>
                <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-gray-400">Jelajahi semua karya inovatif yang telah dipublikasikan oleh para siswa.</p>
            </div>

            {{-- FORM FILTER --}}
            <form action="{{ route('portofolio.gallery') }}" method="GET" class="mb-12" x-data="{
                showAdvanced: false, // <-- State baru untuk toggle
                tagStates: {
                    @foreach($tags as $tag)
                        '{{ $tag->id }}': {{ in_array($tag->id, request('include_tags', [])) ? 1 : (in_array($tag->id, request('exclude_tags', [])) ? 2 : 0) }},
                    @endforeach
                },
                cycleTagState(tagId) {
                    this.tagStates[tagId] = (this.tagStates[tagId] + 1) % 3;
                },
                // Cek apakah ada filter tag yang aktif untuk membuka toggle secara default
                init() {
                    const activeTags = Object.values(this.tagStates).some(state => state > 0);
                    if (activeTags) {
                        this.showAdvanced = true;
                    }
                }
            }">
                {{-- Baris 1: Kontrol Utama --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-2">
                        <input type="text" name="search" placeholder="Cari berdasarkan judul atau nama siswa..."
                               value="{{ request('search') }}"
                               class="w-full h-full rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring-assyifa-500 focus:border-assyifa-500 dark:text-gray-300">
                    </div>
                    
                    <div>
                        <select name="jurusan"
                                class="w-full h-full rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring-assyifa-500 focus:border-assyifa-500 dark:text-gray-300">
                            <option value="">Semua Jurusan</option>
                            <option value="RPL" @selected(request('jurusan') == 'RPL')>Rekayasa Perangkat Lunak</option>
                            <option value="DKV" @selected(request('jurusan') == 'DKV')>Desain Komunikasi Visual</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                         <button type="submit" class="w-full h-full inline-flex items-center justify-center px-4 py-2 bg-assyifa-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-assyifa-500 focus:outline-none focus:ring-2 focus:ring-assyifa-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cari
                        </button>
                        <a href="{{ route('portofolio.gallery') }}" class="w-full h-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                            Reset
                        </a>
                    </div>
                </div>

                {{-- Tombol untuk menampilkan/menyembunyikan filter lanjutan --}}
                <div class="mt-4">
                    <button type="button" @click="showAdvanced = !showAdvanced" class="text-sm font-semibold text-assyifa-600 dark:text-assyifa-500 hover:underline">
                        <span x-show="!showAdvanced">Tampilkan Filter Lanjutan &darr;</span>
                        <span x-show="showAdvanced">Sembunyikan Filter Lanjutan &uarr;</span>
                    </button>
                </div>

                {{-- Filter Tag Lanjutan (Toggleable) --}}
                <div x-show="showAdvanced" x-transition class="mt-4 p-4 border rounded-lg dark:border-gray-700 space-y-4">
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Filter berdasarkan Tag:</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">(Klik untuk include, klik lagi untuk exclude, klik ketiga untuk netral)</p>
                    </div>
                    @foreach($categories as $category)
                        <div>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 text-sm border-b border-gray-200 dark:border-gray-700 pb-1 mb-2">{{ $category->name }}</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($category->tags as $tag)
                                    <span @click="cycleTagState({{ $tag->id }})" class="cursor-pointer rounded-full px-3 py-1 text-xs font-medium transition-colors"
                                          :class="{
                                            'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-200': tagStates[{{ $tag->id }}] == 0,
                                            'bg-assyifa-500 text-white hover:bg-assyifa-600': tagStates[{{ $tag->id }}] == 1,
                                            'bg-red-500 text-white hover:bg-red-600': tagStates[{{ $tag->id }}] == 2,
                                          }">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Hidden inputs --}}
                <div class="hidden">
                    @foreach($tags as $tag)
                        <input type="checkbox" name="include_tags[]" value="{{ $tag->id }}" :checked="tagStates[{{ $tag->id }}] == 1">
                        <input type="checkbox" name="exclude_tags[]" value="{{ $tag->id }}" :checked="tagStates[{{ $tag->id }}] == 2">
                    @endforeach
                </div>
            </form>

            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                 @forelse ($projects as $project)
                    <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80 group">
                        <img src="{{ $project->media->firstWhere('file_type', 'image') ? asset('storage/' . $project->media->firstWhere('file_type', 'image')->file_path) : 'https://placehold.co/600x400/004D40/FFFFFF?text=Project' }}" alt="Gambar Proyek" class="absolute inset-0 -z-10 h-full w-full object-cover transition-transform duration-300 ease-in-out group-hover:scale-105">
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900/80 via-gray-900/40"></div>
                        <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-white"><a href="{{ route('portofolio.show', $project) }}"><span class="absolute inset-0"></span>{{ $project->title }}</a></h3>
                        <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
                            <a href="{{ route('siswa.show', $project->user) }}" class="mr-2 relative z-10 hover:underline">{{ $project->user->name }}</a>
                            <div class="flex items-center gap-x-2"><span class="font-medium bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md px-1.5 py-0.5">{{ $project->user->jurusan }}</span></div>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2 relative z-10">
                            @foreach($project->tags->take(3) as $tag)
                                <span class="inline-block rounded-full bg-gray-50/20 backdrop-blur-sm px-2 py-1 text-xs font-medium text-white">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada proyek yang cocok dengan pencarian Anda.</p>
                        <p class="text-gray-400 dark:text-gray-500 mt-2">Coba ganti kata kunci atau reset filter.</p>
                        <a href="{{ route('portofolio.gallery') }}" class="mt-4 inline-block text-sm text-assyifa-600 dark:text-assyifa-500 hover:underline">Reset Pencarian & Filter</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>