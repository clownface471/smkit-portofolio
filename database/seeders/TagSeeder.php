<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagsByCategory = [
            'Bahasa Pemrograman' => ['PHP', 'JavaScript', 'Python', 'HTML', 'CSS'],
            'Framework & Library' => ['Laravel', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'React', 'Vue.js'],
            'Tools & Platform' => ['MySQL', 'Git', 'GitHub', 'Vite', 'Figma', 'Visual Studio Code'],
            'Tipe Proyek' => ['Website Sekolah', 'Aplikasi Kasir', 'Company Profile', 'Blog', 'Landing Page'],
            'Desain' => ['Desain UI/UX', 'Desain Logo', 'Desain Poster', 'Animasi'],
        ];

        foreach ($tagsByCategory as $categoryName => $tags) {
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                foreach ($tags as $tagName) {
                    Tag::create([
                        'category_id' => $category->id,
                        'name' => $tagName,
                        'slug' => Str::slug($tagName),
                    ]);
                }
            }
        }
    }
}