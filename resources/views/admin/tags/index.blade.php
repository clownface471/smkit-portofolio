<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @if($category)
                    {{ __('Manajemen Tag untuk Kategori: ') . $category->name }}
                @else
                    {{ __('Manajemen Tag') }}
                @endif
            </h2>
            <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Tambah Tag
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
             @if (session('error'))
                <div class="mb-6 bg-red-100 dark:bg-red-900/50 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Tag</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Jurusan Terkait</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $tag)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $tag->name }}</th>
                                        <td class="px-6 py-4">{{ $tag->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            @if(!empty($tag->allowed_jurusan))
                                                @foreach($tag->allowed_jurusan as $jurusan)
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $jurusan }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-400">Semua Jurusan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end space-x-4">
                                                <a href="{{ route('admin.tags.edit', $tag) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus tag ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">Belum ada tag.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

