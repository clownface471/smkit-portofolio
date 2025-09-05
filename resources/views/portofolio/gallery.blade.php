<x-app-layout>
    <div x-data="{ filtersOpen: false }" class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        
        <!-- Page Header -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    Galeri Karya Siswa
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400">
                    Jelajahi inovasi dan kreativitas tanpa batas dari para siswa berprestasi kami.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
            <div class="lg:flex lg:space-x-8 lg:items-start">

                <!-- Mobile Filter Button -->
                <div class="lg:hidden p-4">
                    <button @click="filtersOpen = true" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" /></svg>
                        Tampilkan Filter
                    </button>
                </div>

                <!-- Background Overlay for Mobile -->
                <div x-show="filtersOpen" x-transition:opacity class="fixed inset-0 bg-black/50 z-30 lg:hidden" @click="filtersOpen = false"></div>

                <!-- Filter Sidebar -->
                <aside 
                    class="fixed inset-y-0 left-0 z-40 w-80 max-w-[85vw] transform -translate-x-full transition-transform duration-300 lg:sticky lg:top-8 lg:w-1/4 lg:translate-x-0 lg:inset-auto"
                    :class="{ 'translate-x-0': filtersOpen }"
                >
                    <div class="h-full max-h-[90vh] lg:max-h-[calc(100vh-4rem)] bg-white dark:bg-gray-800 rounded-r-lg shadow-lg lg:shadow-md lg:rounded-lg p-6 overflow-y-auto"
                         x-data="tagFilterHandler({{ json_encode(request('include_tags', [])) }}, {{ json_encode(request('exclude_tags', [])) }})"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Filter Karya</h3>
                            <button @click="filtersOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                        </div>
                        
                        <form action="{{ route('portofolio.gallery') }}" method="GET">
                            <!-- Search -->
                            <div class="mb-4">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pencarian</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Judul atau nama siswa..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <!-- Jurusan -->
                            <div class="mb-4">
                                <label for="jurusan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jurusan</label>
                                <select name="jurusan" id="jurusan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Semua Jurusan</option>
                                    <option value="RPL" @selected(request('jurusan') == 'RPL')>RPL</option>
                                    <option value="TKJ" @selected(request('jurusan') == 'TKJ')>TKJ</option>
                                    <option value="DKV" @selected(request('jurusan') == 'DKV')>DKV</option>
                                </select>
                            </div>

                            <!-- Advanced Tags Section -->
                            @foreach ($categories as $category)
                                <div class="mb-2 border-t border-gray-200 dark:border-gray-700 pt-2" x-data="{ open: false }">
                                    <button type="button" @click="open = !open" class="flex justify-between items-center w-full font-semibold text-left text-gray-800 dark:text-gray-200 py-2">
                                        <span>{{ $category->name }}</span>
                                        <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-collapse.duration.300ms class="mt-2 pl-2 space-y-2">
                                        @foreach ($category->tags as $tag)
                                            <div class="flex items-center">
                                                <button type="button" @click="cycleTag({{ $tag->id }})" 
                                                        class="w-full text-left text-sm px-3 py-1 rounded-md transition-colors"
                                                        :class="{
                                                            'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300': tags[{{ $tag->id }}] === 1,
                                                            'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300 line-through': tags[{{ $tag->id }}] === 2,
                                                            'bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600/50': tags[{{ $tag->id }}] === 0 || tags[{{ $tag->id }}] === undefined
                                                        }">
                                                    {{ $tag->name }}
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Hidden inputs for submission -->
                            <template x-for="tagId in Object.keys(tags).filter(id => tags[id] === 1)"><input type="hidden" name="include_tags[]" :value="tagId"></template>
                            <template x-for="tagId in Object.keys(tags).filter(id => tags[id] === 2)"><input type="hidden" name="exclude_tags[]" :value="tagId"></template>

                            <div class="mt-6 border-t pt-6 border-gray-200 dark:border-gray-700">
                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terapkan Filter</button>
                                <a href="{{ route('portofolio.gallery') }}" class="mt-2 block text-center text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Reset Filter</a>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Gallery Grid -->
                <main class="w-full lg:w-3/4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @forelse ($projects as $project) <x-project-card :project="$project" /> @empty
                            <div class="col-span-full text-center py-24 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada proyek yang cocok dengan kriteria pencarian Anda.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-8">{{ $projects->links() }}</div>
                </main>
            </div>
        </div>

        <script>
            function tagFilterHandler(initialIncludes, initialExcludes) {
                return {
                    tags: {},
                    init() {
                        initialIncludes.forEach(id => this.tags[id] = 1);
                        initialExcludes.forEach(id => this.tags[id] = 2);
                    },
                    cycleTag(tagId) {
                        if (this.tags[tagId] === undefined || this.tags[tagId] === null) {
                            this.tags[tagId] = 0;
                        }
                        this.tags[tagId] = (this.tags[tagId] + 1) % 3; // 0 -> 1 -> 2 -> 0
                    }
                }
            }
        </script>
    </div>
</x-app-layout>

