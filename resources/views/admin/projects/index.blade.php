<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Proyek (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul</th>
                                    <th scope="col" class="px-6 py-3">Siswa</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $project)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $project->title }}</th>
                                        <td class="px-6 py-4">{{ $project->user->name }}</td>
                                        <td class="px-6 py-4">
                                            {{-- Status Badge --}}
                                            @if ($project->status == 'published')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Published</span>
                                            @elseif ($project->status == 'pending_review')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Review</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Draft</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('projects.preview', $project) }}" target="_blank" class="font-medium text-purple-600 dark:text-purple-500 hover:underline">Preview</a>

                                                @if ($project->status == 'published')
                                                    {{-- Tombol Tarik Publikasi --}}
                                                    <form method="POST" action="{{ route('admin.projects.retract', $project) }}" onsubmit="return confirm('Apakah Anda yakin ingin menarik proyek ini dari halaman publik?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Tarik</button>
                                                    </form>

                                                    {{-- Tombol Jadikan Unggulan --}}
                                                    <form action="{{ route('admin.projects.toggle-feature', $project) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if ($project->is_featured)
                                                            <button type="submit" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">Batalkan</button>
                                                        @else
                                                            <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline">Unggulkan</button>
                                                        @endif
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">Belum ada proyek sama sekali.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-8">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>