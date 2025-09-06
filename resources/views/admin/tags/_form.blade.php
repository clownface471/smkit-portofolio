<div class="space-y-6">
    {{-- Nama Tag --}}
    <div>
        <x-input-label for="name" :value="__('Nama Tag')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $tag->name ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Kategori --}}
    <div>
        <x-input-label for="category_id" :value="__('Kategori')" />
        <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $tag->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>

    {{-- Jurusan --}}
    <div>
        <x-input-label :value="__('Batasi untuk Jurusan (Kosongkan untuk Semua)')" />
        <div class="mt-2 space-y-2">
            @php
                $jurusans = ['RPL', 'DKV'];
                $selectedJurusans = old('allowed_jurusan', $tag->allowed_jurusan ?? []);
            @endphp
            @foreach($jurusans as $jurusan)
            <label class="inline-flex items-center">
                <input type="checkbox" name="allowed_jurusan[]" value="{{ $jurusan }}" 
                       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                       @checked(in_array($jurusan, $selectedJurusans))>
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $jurusan }}</span>
            </label>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('allowed_jurusan')" class="mt-2" />
    </div>
</div>


<div class="flex items-center justify-end mt-6">
    <a href="{{ route('admin.tags.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        {{ __('Batal') }}
    </a>
    <x-primary-button class="ms-4">
        {{ isset($tag) ? __('Update') : __('Simpan') }}
    </x-primary-button>
</div>
