<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard for the user's role.
     */
    public function index(): View
    {
        $user = Auth::user();
        $role = $user->role;

        // Siapkan data navigasi berdasarkan peran
        $navigationItems = $this->getNavigationItemsForRole($role);

        return view('dashboard', [
            'navigationItems' => $navigationItems,
        ]);
    }

    /**
     * Get navigation items based on user role.
     */
    private function getNavigationItemsForRole(string $role): array
    {
        $commonItems = [
            'profile' => [
                'title' => 'Profil Saya',
                'description' => 'Perbarui informasi pribadi, avatar, dan bio Anda.',
                'route' => 'profile.edit',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
            ]
        ];

        $roleSpecificItems = [];

        switch ($role) {
            case 'admin':
                $roleSpecificItems = [
                    'content' => [
                        'title' => 'Manajemen Konten',
                        'description' => 'Kelola semua proyek, kategori, dan tag yang ada di platform.',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>',
                        'links' => [
                            ['name' => 'Semua Proyek', 'route' => 'admin.projects.index'],
                            ['name' => 'Kategori', 'route' => 'admin.categories.index'],
                            ['name' => 'Tag', 'route' => 'admin.tags.index'],
                        ]
                    ],
                    'users' => [
                        'title' => 'Manajemen Pengguna',
                        'description' => 'Tambah, edit, atau hapus akun siswa, guru, dan admin.',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.125-1.274-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.125-1.274.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
                        'links' => [
                            ['name' => 'Lihat Semua Pengguna', 'route' => 'admin.users.index'],
                            ['name' => 'Tambah Pengguna Baru', 'route' => 'admin.users.create'],
                        ]
                    ],
                    'settings' => [
                        'title' => 'Pengaturan Situs',
                        'description' => 'Ubah teks dan konten di halaman publik tanpa menyentuh kode.',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.096 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>',
                        'links' => [
                            ['name' => 'Ubah Pengaturan', 'route' => 'admin.settings.index'],
                        ]
                    ]
                ];
                break;

            case 'guru':
                $roleSpecificItems = [
                    'review' => [
                        'title' => 'Review Proyek Siswa',
                        'description' => 'Tinjau, setujui, atau tolak proyek yang diajukan oleh siswa.',
                        'route' => 'review.index',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                    ]
                ];
                break;

            case 'siswa':
                $roleSpecificItems = [
                    'projects' => [
                        'title' => 'Proyek Saya',
                        'description' => 'Lihat, tambah, atau edit semua karya portofolio yang Anda miliki.',
                        'route' => 'projects.index',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>',
                    ]
                ];
                break;
        }

        return array_merge($roleSpecificItems, $commonItems);
    }
}

