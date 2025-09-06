<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Review: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- KOTAK AKSI PENINJAUAN --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aksi Peninjauan</h3>
                        <a href="{{ route('review.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                            ← Kembali ke Daftar Review
                        </a>
                    </div>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Tinjau detail proyek di bawah ini. Anda dapat melihat pratinjau publik terlebih dahulu sebelum mengambil keputusan.
                    </p>
                    
                    {{-- Kumpulan Tombol Aksi yang Sudah Diperbaiki --}}
                    <div class="mt-6 flex items-center gap-4">
                        <a href="{{ route('projects.preview', $project) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            Lihat Preview
                        </a>

                        @if ($project->status == 'pending_review')
                            {{-- Tombol untuk proyek yang MENUNGGU REVIEW --}}
                            <x-primary-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'approve-project-modal')"
                            >{{ __('Setujui') }}</x-primary-button>
                            
                            <x-danger-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'reject-project-modal')"
                            >{{ __('Tolak') }}</x-danger-button>

                        @elseif ($project->status == 'published')
                            {{-- Tampilan untuk proyek yang SUDAH DISETUJUI --}}
                            <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Telah Dipublikasikan
                            </span>

                            {{-- Tombol Feature HANYA untuk ADMIN --}}
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('admin.projects.toggle-feature', $project) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                @if($project->is_featured)
                                    <x-secondary-button type="submit" class="inline-flex items-center">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                                        Batalkan Unggulan
                                    </x-secondary-button>
                                @else
                                    <x-primary-button type="submit" class="bg-yellow-500 hover:bg-yellow-600 focus:bg-yellow-700 active:bg-yellow-900 focus:ring-yellow-500 inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                        Jadikan Unggulan
                                    </x-primary-button>
                                @endif
                            </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOTAK INFORMASI PENGAJUAN --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-none">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Pengajuan</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex flex-col">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nama Siswa</dt>
                            <dd class="text-gray-900 dark:text-gray-100 mt-1">{{ $project->user->name }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Jurusan</dt>
                            <dd class="text-gray-900 dark:text-gray-100 mt-1">{{ $project->user->jurusan }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Email Siswa</dt>
                            <dd class="text-gray-900 dark:text-gray-100 mt-1">{{ $project->user->email }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Waktu Pengajuan</dt>
                            <dd class="text-gray-900 dark:text-gray-100 mt-1">{{ $project->updated_at->format('d F Y, H:i') }}</dd>
                        </div>
                    </dl>
                    <hr class="my-6 border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Deskripsi Proyek</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $project->description }}</p>

                    @include('projects.partials.comments-section')
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Approve --}}
    <x-modal name="approve-project-modal" :show="false" focusable>
        <form method="post" action="{{ route('review.approve', $project) }}" class="p-6">
            @csrf
            @method('patch')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Apakah Anda yakin ingin mempublikasikan proyek ini?
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Setelah dipublikasikan, proyek ini akan dapat dilihat oleh semua orang.
            </p>
            <input type="hidden" name="confirmation" value="true">
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">
                    {{ __('Ya, Publikasikan') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Reject --}}
    <x-modal name="reject-project-modal" :show="false" focusable>
        <form method="post" action="{{ route('review.reject', $project) }}" class="p-6">
            @csrf
            @method('patch')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Tolak dan Kembalikan Proyek
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Tuliskan alasan penolakan di bawah ini.
            </p>
            <div class="mt-6">
                <x-input-label for="rejection_reason" value="Alasan Penolakan" class="sr-only" />
                <textarea
                    id="rejection_reason"
                    name="rejection_reason"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Contoh: Mockup perlu diperbaiki..."
                ></textarea>
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>
                <x-danger-button class="ms-3">
                    {{ __('Kirim Penolakan') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>

