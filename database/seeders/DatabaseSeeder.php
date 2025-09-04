<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'jurusan' => 'RPL',
        ]);

        // Membuat Guru RPL
        User::factory()->create([
            'name' => 'Guru RPL',
            'email' => 'guru-rpl@example.com',
            'role' => 'guru',
            'jurusan' => 'RPL',
        ]);

        // Membuat Guru DKV
        User::factory()->create([
            'name' => 'Guru DKV',
            'email' => 'guru-dkv@example.com',
            'role' => 'guru',
            'jurusan' => 'DKV',
        ]);

        // Membuat 10 siswa RPL dan 10 siswa DKV
        User::factory(10)->create(['role' => 'siswa', 'jurusan' => 'RPL']);
        User::factory(10)->create(['role' => 'siswa', 'jurusan' => 'DKV']);

        // Memanggil seeder untuk kategori dan tag
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
        ]);
    }
}