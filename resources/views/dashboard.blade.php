    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if (session('status') === 'profile-updated')
                        <div class="mb-4 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4" role="alert">
                            <p>Profil Anda berhasil diperbarui.</p>
                        </div>
                    @endif
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Selamat datang kembali, {{ Auth::user()->name }}! Anda login sebagai {{ ucfirst(Auth::user()->role) }}.
                    </div>
                </div>

                <!-- Konten Dinamis Berdasarkan Peran -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    @if(Auth::user()->role === 'siswa')
                        <!-- === KONTEN UNTUK SISWA === -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Proyek Anda</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat, tambah, atau edit portofolio proyek yang sudah Anda kerjakan.</p>
                                <a href="{{ route('projects.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                    Kelola Proyek Saya &rarr;
                                </a>
                            </div>
                        </div>

                    @elseif(Auth::user()->role === 'guru')
                        <!-- === KONTEN UNTUK GURU === -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Review Proyek</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat dan berikan persetujuan untuk proyek yang diajukan oleh siswa.</p>
                                <a href="{{ route('review.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                    Buka Panel Review &rarr;
                                </a>
                            </div>
                        </div>

                    @elseif(Auth::user()->role === 'admin')
                        <!-- === KONTEN UNTUK ADMIN === -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Review Proyek</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat dan berikan persetujuan untuk proyek yang diajukan oleh siswa.</p>
                                <a href="{{ route('review.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                    Buka Panel Review &rarr;
                                </a>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manajemen Pengguna</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Tambah, edit, atau hapus akun untuk siswa dan guru.</p>
                                <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                    Kelola Pengguna &rarr;
                                </a>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manajemen Proyek</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat semua proyek dan tarik kembali (unpublish) karya jika diperlukan.</p>
                                <a href="{{ route('admin.projects.index') }}" class="mt-4 inline-block font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                    Buka Moderasi Proyek &rarr;
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </x-app-layout>
    

