<x-app-layout>
    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- BAGIAN PROFIL HEADER --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    {{-- Avatar --}}
                    <div>
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar {{ $user->name }}" class="w-24 h-24 rounded-full object-cover ring-4 ring-indigo-300 dark:ring-indigo-600">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-3xl font-bold ring-4 ring-gray-300 dark:ring-gray-600">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Nama, Jurusan, dan Bio --}}
                    <div class="text-center sm:text-left">
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $user->name }}</h2>
                        <p class="text-lg text-indigo-500 dark:text-indigo-400 font-semibold">{{ $user->jurusan }}</p>

                        @if ($user->bio)
                            <p class="mt-2 text-gray-600 dark:text-gray-400 max-w-2xl">
                                {{ $user->bio }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- BAGIAN DAFTAR KARYA --}}
            <div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Karya Portofolio:</h3>
                @if($user->projects->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($user->projects as $project)
                            <x-project-card :project="$project" />
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <p class="text-gray-500 dark:text-gray-400">Siswa ini belum memiliki karya yang dipublikasikan.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>