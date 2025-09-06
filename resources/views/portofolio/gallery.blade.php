<x-guest-layout>
    <div class="bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">Galeri Karya Siswa</h1>
                <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-400">Jelajahi, saring, dan temukan karya-karya inovatif dari siswa kami.</p>
            </div>

            <!-- Main Content Area -->
            <div x-data="{ filtersOpen: false }" class="relative lg:grid lg:grid-cols-4 lg:gap-8 lg:items-start">

                <!-- Mobile Filter Button -->
                <div class="lg:hidden mb-6">
                    <button @click="filtersOpen = true" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Tampilkan Filter
                    </button>
                </div>

                <!-- Filters Sidebar -->
                <aside 
                    :class="{'block': filtersOpen, 'hidden': !filtersOpen}"
                    class="fixed inset-0 z-40 p-6 lg:z-10 lg:sticky lg:top-24 lg:col-span-1 lg:self-start lg:block lg:p-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm lg:bg-transparent lg:dark:bg-transparent lg:backdrop-blur-none"
                >
                    <div class="relative h-full overflow-y-auto lg:max-h-[calc(100vh-14rem)]" @click.away="filtersOpen = false">
                        <div class="lg:pr-4" @click.stop>
                            <!-- Sidebar Header (Mobile) -->
                            <div class="flex items-center justify-between lg:hidden mb-4">
                                <h2 class="text-lg font-semibold dark:text-white">Filter</h2>
                                <button @click="filtersOpen = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <form action="{{ route('portofolio.gallery') }}" method="GET" x-data="{
                                init() {
                                    const urlParams = new URLSearchParams(window.location.search);
                                    urlParams.getAll('include_tags[]').forEach(id => this.toggleTag(id, 'include'));
                                    urlParams.getAll('exclude_tags[]').forEach(id => this.toggleTag(id, 'exclude'));
                                },
                                tags: {},
                                toggleTag(tagId, forceState = null) {
                                    const currentState = this.tags[tagId] || 'neutral';
                                    let nextState;
                            
                                    if (forceState) {
                                        nextState = forceState;
                                    } else {
                                        if (currentState === 'neutral') nextState = 'include';
                                        else if (currentState === 'include') nextState = 'exclude';
                                        else nextState = 'neutral';
                                    }
                                    this.tags[tagId] = nextState;
                                },
                                tagClass(tagId) {
                                    const state = this.tags[tagId] || 'neutral';
                                    if (state === 'include') return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 ring-1 ring-inset ring-green-600/20 dark:ring-green-500/30';
                                    if (state === 'exclude') return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 ring-1 ring-inset ring-red-600/20 dark:ring-red-500/30';
                                    return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-400/20';
                                },
                                createHiddenInput(name, value) {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = name;
                                    input.value = value;
                                    return input;
                                },
                                applyTags(event) {
                                    Object.entries(this.tags).forEach(([tagId, state]) => {
                                        if (state === 'include') {
                                            event.target.appendChild(this.createHiddenInput('include_tags[]', tagId));
                                        } else if (state === 'exclude') {
                                            event.target.appendChild(this.createHiddenInput('exclude_tags[]', tagId));
                                        }
                                    });
                                }
                            }" @submit="applyTags">

                                <div class="space-y-6">
                                    <!-- Search -->
                                    <div>
                                        <label for="search" class="block text-sm font-medium text-gray-900 dark:text-white">Pencarian</label>
                                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Judul proyek atau nama siswa..." class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200">
                                    </div>

                                    <!-- Jurusan -->
                                    <div>
                                        <label for="jurusan" class="block text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                                        <select name="jurusan" id="jurusan" class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200">
                                            <option value="">Semua Jurusan</option>
                                            <option value="RPL" @selected(request('jurusan') == 'RPL')>RPL</option>
                                            <option value="DKV" @selected(request('jurusan') == 'DKV')>DKV</option>
                                        </select>
                                    </div>

                                    <!-- Tags (Simplified Layout) -->
                                    <div x-data="{ tagsOpen: false }" class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                        <button type="button" @click="tagsOpen = !tagsOpen" class="flex items-center justify-between w-full text-sm font-medium text-gray-900 dark:text-white">
                                            <span>Filter Berdasarkan Tag</span>
                                            <svg :class="{'rotate-180': tagsOpen}" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                        </button>
                                        <div x-show="tagsOpen" x-collapse.duration.300ms class="mt-4 space-y-4">
                                            @foreach($categories as $category)
                                                <div>
                                                    <h4 class="mb-2 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">{{ $category->name }}</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($category->tags as $tag)
                                                            <button type="button" @click="toggleTag('{{ $tag->id }}')" :class="tagClass('{{ $tag->id }}')" class="text-xs font-medium px-2.5 py-1 rounded-full transition-colors">
                                                                {{ $tag->name }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    @if(!$loop->last)
                                                        <hr class="mt-4 border-gray-200 dark:border-gray-700">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Filter Actions -->
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 flex items-center space-x-2">
                                        <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800">Terapkan</button>
                                        <a href="{{ route('portofolio.gallery') }}" class="w-full text-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>

                <!-- Project Grid -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($projects as $project)
                            <x-project-card :project="$project" />
                        @empty
                            <div class="col-span-full text-center py-16">
                                <p class="text-gray-500 dark:text-gray-400">Tidak ada proyek yang cocok dengan kriteria pencarian Anda.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $projects->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>

