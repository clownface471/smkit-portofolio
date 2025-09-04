<div class="mt-6">
    <x-input-label for="tags" :value="__('Teknologi & Kategori Proyek')" />
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Pilih semua tag yang relevan dengan proyek Anda. Ini akan membantu orang lain menemukan karya Anda.
    </p>

    <div class="mt-4 space-y-4">
        @foreach ($categories as $category)
            <div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ $category->name }}</h4>
                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($category->tags as $tag)
                        <label for="tag-{{ $tag->id }}" class="flex items-center space-x-2">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
                                   class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-assyifa-600 shadow-sm focus:ring-assyifa-500 dark:focus:ring-assyifa-600 dark:focus:ring-offset-gray-800"
                                   @if(isset($projectTagIds) && in_array($tag->id, $projectTagIds)) checked @endif
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
</div>