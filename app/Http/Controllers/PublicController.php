<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     */
    public function home(): View
    {
        // Ambil 6 proyek terbaru yang sudah dipublikasikan sebagai "featured"
        $featuredProjects = Project::where('status', 'published')
                                    ->with('user', 'media')
                                    ->latest()
                                    ->take(6)
                                    ->get();

        return view('home', [
            'featuredProjects' => $featuredProjects
        ]);
    }

    /**
     * Menampilkan halaman galeri portofolio.
     */
    public function gallery(Request $request)
    {
        // Mulai query untuk mengambil proyek yang sudah 'published'
        $query = Project::where('status', 'published');

        // Filter berdasarkan pencarian (search)
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->where('jurusan', $request->jurusan);
            });
        }

        // Ambil data hasil query, urutkan dari yang terbaru, dan paginasi
        $projects = $query->with('user', 'media')
                        ->latest()
                        ->paginate(12)
                        ->withQueryString(); // Agar filter tetap aktif saat pindah halaman

        return view('portofolio.gallery', compact('projects'));
    }
    /**
     * Menampilkan halaman detail satu proyek.
     */

    // TAMBAHKAN METHOD INI DI DALAM CLASS PUBLIC CONTROLLER
    public function showSiswa(User $user)
    {
        // Load relasi projects, tapi hanya yang sudah berstatus 'published'
        $user->load(['projects' => function ($query) {
            $query->where('status', 'published')->latest();
        }]);

        return view('portofolio.siswa-show', compact('user'));
    }
    public function show(Project $project): View
    {
        if ($project->status !== 'published') {
            abort(404);
        }

        // Ganti view yang digunakan di sini
        return view('portofolio.show', [
            'project' => $project->load('user', 'media')
        ]);
    }
}