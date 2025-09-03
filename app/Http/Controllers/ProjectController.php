<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini
use Illuminate\View\View;

class ProjectController extends Controller
{
    // ... fungsi index(), create() tidak berubah ...
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->latest()->get();
        return view('projects.index', ['projects' => $projects]);
    }

    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi semua input, termasuk file gambar
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'github_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'images' => 'nullable|array', // Pastikan 'images' adalah array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi setiap file
        ]);

        // 2. Buat proyek dengan data teks terlebih dahulu
        $project = $request->user()->projects()->create($validated);

        // 3. Jika ada file gambar yang diunggah, proses dan simpan
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Simpan file ke storage/app/public/project-images
                // dan dapatkan path-nya
                $path = $image->store('project-images', 'public');

                // Buat record baru di tabel project_media
                $project->media()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                ]);
            }
        }

        return redirect(route('projects.index'))->with('success', 'Proyek berhasil ditambahkan!');
    }

    // ... sisa controller (edit, update, destroy, dll) akan kita perbarui nanti ...
    public function edit(Request $request, Project $project): View
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }
        return view('projects.edit', ['project' => $project]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        // Logika update akan kita tambahkan nanti
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'github_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
        ]);
        $project->update($validated);
        return redirect(route('projects.index'))->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        // Hapus juga file dari storage saat proyek dihapus
        foreach($project->media as $media) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        $project->delete();
        return redirect(route('projects.index'))->with('success', 'Proyek berhasil dihapus!');
    }

    public function submitForReview(Request $request, Project $project): RedirectResponse
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }
        $project->status = 'pending_review';
        $project->save();
        return redirect(route('projects.index'))->with('success', 'Proyek berhasil diajukan untuk direview!');
    }
}

