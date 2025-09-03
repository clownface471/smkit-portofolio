    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Review Proyek Siswa') }}
            </h2>
        </x-slot>
    
        <div class="py-12" x-data="{ showRejectModal: false, rejectUrl: '' }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul Proyek</th>
                                    <th scope="col" class="px-6 py-3">Diajukan oleh</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $project)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $project->title }}
                                        </th>
                                        <td class="px-6 py-4">{{ $project->user->name }}</td>
                                        <td class="px-6 py-4 flex items-center space-x-4">
                                            <form method="POST" action="{{ route('review.approve', $project) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline">Setujui</button>
                                            </form>
                                            <!-- Tombol Tolak baru yang membuka modal -->
                                            <button @click="showRejectModal = true; rejectUrl = '{{ route('review.reject', $project) }}'" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                Tolak
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">Tidak ada proyek yang perlu direview saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
            <!-- Modal untuk Alasan Penolakan -->
            <div x-show="showRejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-cloak>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div @click.away="showRejectModal = false" class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form :action="rejectUrl" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100" id="modal-title">Alasan Penolakan</h3>
                                    <div class="mt-2">
                                        <textarea name="rejection_reason" rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Tuliskan feedback atau alasan penolakan di sini..." required></textarea>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Kirim Penolakan</button>
                                    <button type="button" @click="showRejectModal = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:mt-0 sm:w-auto">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    

