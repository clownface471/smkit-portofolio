<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
    public function gallery(): View
    {
        // Ambil semua proyek yang sudah dipublikasikan, dengan paginasi
        $projects = Project::where('status', 'published')
                            ->with('user', 'media')
                            ->latest()
                            ->paginate(12);

        return view('portofolio.gallery', [
            'projects' => $projects
        ]);
    }

    /**
     * Menampilkan halaman detail satu proyek.
     */
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