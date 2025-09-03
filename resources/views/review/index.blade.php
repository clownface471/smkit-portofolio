<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Review Proyek Siswa') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
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
                                            {{-- Nanti kita bisa buat ini jadi link ke detail proyek --}}
                                            {{ $project->title }}
                                        </th>
                                        <td class="px-6 py-4">{{ $project->user->name }}</td>
                                        <td class="px-6 py-4 flex items-center space-x-4">
                                            <form method="POST" action="{{ route('review.approve', $project) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('review.reject', $project) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="3" class="px-6 py-4 text-center">Tidak ada proyek yang perlu direview saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

