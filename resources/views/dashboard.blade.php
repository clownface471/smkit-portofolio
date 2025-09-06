<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Selamat Datang --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Selamat datang kembali, {{ Auth::user()->name }}! Anda login sebagai {{ ucfirst(Auth::user()->role) }}.
                </div>
            </div>

            {{-- Pesan Notifikasi (misal: setelah update profil) --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-6 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-md" role="alert">
                    <p>Profil Anda berhasil diperbarui.</p>
                </div>
            @endif

            {{-- KONTEN DINAMIS BERDASARKAN PERAN PENGGUNA --}}

            @if(Auth::user()->role === 'admin')
                {{-- =================== --}}
                {{-- === PANEL ADMIN === --}}
                {{-- =================== --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- KARTU MANAJEMEN KONTEN -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" /></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manajemen Konten</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Atur semua proyek, kategori, dan tag yang ada di dalam sistem.</p>
                        <div class="space-y-2">
                            <a href="{{ route('admin.projects.index') }}" class="block text-indigo-600 dark:text-indigo-400 hover:underline">Moderasi Proyek</a>
                            <a href="{{ route('admin.categories.index') }}" class="block text-indigo-600 dark:text-indigo-400 hover:underline">Manajemen Kategori</a>
                            <a href="{{ route('admin.tags.index') }}" class="block text-indigo-600 dark:text-indigo-400 hover:underline">Manajemen Tag</a>
                        </div>
                    </div>

                    <!-- KARTU MANAJEMEN PENGGUNA -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.003A6.375 6.375 0 0112 21c-2.21 0-4.21-.896-5.657-2.343a6.375 6.375 0 01-2.343-5.657c0-2.21.896-4.21 2.343-5.657a6.375 6.375 0 015.657-2.343c2.21 0 4.21.896 5.657 2.343A6.375 6.375 0 0121 12c0 2.21-.896 4.21-2.343 5.657a6.375 6.375 0 01-5.657 2.343z" /></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manajemen Pengguna</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Kelola akun untuk siswa, guru, dan administrator lainnya.</p>
                        <div class="space-y-2">
                             <a href="{{ route('admin.users.index') }}" class="block text-indigo-600 dark:text-indigo-400 hover:underline">Kelola Akun</a>
                             <a href="{{ route('review.index') }}" class="block text-indigo-600 dark:text-indigo-400 hover:underline">Review Proyek Siswa</a>
                        </div>
                    </div>

                    <!-- KARTU PENGATURAN SITUS -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-sky-100 dark:bg-sky-900 p-2 rounded-full">
                               <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.242 1.453l-1.005.827c-.297.243-.473.61-.473.992v.456c0 .382.176.749.473.992l1.005.827c.424.35.532.954.242 1.453l-1.296 2.247a1.125 1.125 0 01-1.37.49l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.333.183-.582.495-.645.87l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.063-.374-.313-.686-.645-.87a6.52 6.52 0 01-.22-.127c-.324-.196-.72-.257-1.075-.124l-1.217.456a1.125 1.125 0 01-1.37-.49l-1.296-2.247a1.125 1.125 0 01.242-1.453l1.005-.827c.297-.243.473-.61.473-.992v-.456c0-.382-.176-.749-.473-.992l-1.005-.827a1.125 1.125 0 01-.242-1.453l1.296-2.247a1.125 1.125 0 011.37-.49l1.217.456c.355.133.75.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.87l.213-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pengaturan</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Ubah teks dan konten lain yang tampil di halaman publik.</p>
                        <div class="space-y-2">
                            <a href="{{ route('admin.settings.index') }}" class="block text-indigo-600 dark:text-indigo-400 hover:underline">Kustomisasi Homepage</a>
                        </div>
                    </div>

                </div>

            @elseif(Auth::user()->role === 'guru')
                {{-- =================== --}}
                {{-- === PANEL GURU === --}}
                {{-- =================== --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Review Proyek Siswa</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat dan berikan persetujuan untuk proyek yang diajukan oleh siswa.</p>
                        <a href="{{ route('review.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                            Buka Panel Review &rarr;
                        </a>
                    </div>
                </div>

            @elseif(Auth::user()->role === 'siswa')
                {{-- ==================== --}}
                {{-- === PANEL SISWA === --}}
                {{-- ==================== --}}
                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Proyek Anda</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat, tambah, atau edit portofolio proyek yang sudah Anda kerjakan.</p>
                        <a href="{{ route('projects.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                            Kelola Proyek Saya &rarr;
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

