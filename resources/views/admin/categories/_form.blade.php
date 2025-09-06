<div>
    <x-input-label for="name" :value="__('Nama Kategori')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        {{ __('Batal') }}
    </a>
    <x-primary-button class="ms-4">
        {{ isset($category) ? __('Update') : __('Simpan') }}
    </x-primary-button>
</div>
