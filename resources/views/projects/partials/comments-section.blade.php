<div class="mt-8 pt-8 border-t dark:border-gray-700">
    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
        Diskusi & Feedback Proyek
    </h3>

    {{-- Form untuk Menambah Komentar Baru --}}
    <form action="{{ route('comments.store', $project) }}" method="POST" class="mb-6">
        @csrf
        <div>
            <x-input-label for="body" value="Tulis Komentar" class="sr-only" />
            <textarea name="body" id="body" rows="4"
                      class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-assyifa-500 dark:focus:border-assyifa-600 focus:ring-assyifa-500 dark:focus:ring-assyifa-600 rounded-md shadow-sm"
                      placeholder="Tuliskan feedback, pertanyaan, atau catatan revisi di sini..."></textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-primary-button>Kirim Komentar</x-primary-button>
        </div>
    </form>

    {{-- Daftar Komentar yang Sudah Ada --}}
    <div class="space-y-6">
        @forelse ($project->comments as $comment)
            <div class="flex items-start gap-4">
                {{-- Avatar Pengguna --}}
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-600 dark:text-gray-300">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                {{ $comment->user->name }}
                                @if($comment->user->role === 'guru' || $comment->user->role === 'admin')
                                    <span class="ml-2 text-xs font-medium text-white bg-assyifa-500 rounded-full px-2 py-0.5">Guru</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 whitespace-pre-wrap">{{ $comment->body }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada komentar. Jadilah yang pertama memberikan feedback!</p>
        @endforelse
    </div>
</div>