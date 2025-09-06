<div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
        Panel Navigasi Admin
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            Manajemen User
        </a>
        <a href="{{ route('admin.projects.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            Manajemen Proyek
        </a>
        <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            Manajemen Kategori
        </a>
        <a href="{{ route('admin.tags.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            Manajemen Tag
        </a>
        <a href="{{ route('admin.settings.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            Pengaturan Situs
        </a>
    </div>
</div>

