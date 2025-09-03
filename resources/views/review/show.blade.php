<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Review: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aksi Peninjauan</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Tinjau detail proyek di bawah ini. Anda dapat melihat pratinjau publik terlebih dahulu sebelum mengambil keputusan.
                    </p>
                    <div class="mt-6 flex items-center gap-4">
                        <a href="{{ route('projects.preview', $project) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            Lihat Preview
                        </a>
                        <x-primary-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'approve-project-modal')"
                        >{{ __('Setujui') }}</x-primary-button>
                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'reject-project-modal')"
                        >{{ __('Tolak') }}</x-danger-button>
                    </div>
                </div>
            </div>

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
                </div>
            </div>
        </div>
    </div>

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