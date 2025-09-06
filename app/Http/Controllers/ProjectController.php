<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the user's projects.
     */
    public function index(): View
    {
        $projects = Project::where('user_id', Auth::id())->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        $jurusan = Auth::user()->jurusan;

        $categories = Category::with(['tags' => function ($query) use ($jurusan) {
            $query->whereNull('allowed_jurusan') // Ambil tag yang untuk semua jurusan
                  ->orWhereJsonContains('allowed_jurusan', $jurusan); // Atau yang spesifik untuk jurusan user
        }])->whereHas('tags', function ($query) use ($jurusan) { // Pastikan kategori punya tag yang relevan
            $query->whereNull('allowed_jurusan')
                  ->orWhereJsonContains('allowed_jurusan', $jurusan);
        })->get();

        return view('projects.create', compact('categories'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'media_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'media_videos.*' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:10240',
            'video_links.*' => 'nullable|url',
            'github_link' => 'nullable|url',
            'demo_link' => 'nullable|url',
            'figma_link' => 'nullable|url',
        ]);

        $project = auth()->user()->projects()->create($validated);

        if ($request->has('tags')) {
            $project->tags()->sync($request->tags);
        }

        if ($request->hasFile('media_images')) {
            foreach ($request->file('media_images') as $file) {
                $path = $file->store('project-media', 'public');
                $project->media()->create(['file_path' => $path, 'file_type' => 'image']);
            }
        }
        
        if ($request->hasFile('media_videos')) {
            foreach ($request->file('media_videos') as $file) {
                $path = $file->store('project-media', 'public');
                $project->media()->create(['file_path' => $path, 'file_type' => 'video']);
            }
        }

        if ($request->filled('video_links')) {
            foreach ($request->video_links as $link) {
                if($link) {
                    $project->media()->create(['video_url' => $link, 'file_type' => 'embed']);
                }
            }
        }

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        Gate::authorize('update', $project);

        $jurusan = Auth::user()->jurusan;

        $categories = Category::with(['tags' => function ($query) use ($jurusan) {
            $query->whereNull('allowed_jurusan') // Ambil tag yang untuk semua jurusan
                  ->orWhereJsonContains('allowed_jurusan', $jurusan); // Atau yang spesifik untuk jurusan user
        }])->whereHas('tags', function ($query) use ($jurusan) { // Pastikan kategori punya tag yang relevan
            $query->whereNull('allowed_jurusan')
                  ->orWhereJsonContains('allowed_jurusan', $jurusan);
        })->get();
        
        $selectedTags = $project->tags->pluck('id')->toArray();

        return view('projects.edit', compact('project', 'categories', 'selectedTags'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'media_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'media_videos.*' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:10240',
            'video_links.*' => 'nullable|url',
            'github_link' => 'nullable|url',
            'demo_link' => 'nullable|url',
            'figma_link' => 'nullable|url',
        ]);

        $project->update($validated);

        $project->tags()->sync($request->tags ?? []);

        if ($request->hasFile('media_images')) {
            foreach ($request->file('media_images') as $file) {
                $path = $file->store('project-media', 'public');
                $project->media()->create(['file_path' => $path, 'file_type' => 'image']);
            }
        }

        if ($request->hasFile('media_videos')) {
            foreach ($request->file('media_videos') as $file) {
                $path = $file->store('project-media', 'public');
                $project->media()->create(['file_path' => $path, 'file_type' => 'video']);
            }
        }
        
        if ($request->filled('video_links')) {
            foreach ($request->video_links as $link) {
                 if($link && !$project->media()->where('video_url', $link)->exists()) {
                    $project->media()->create(['video_url' => $link, 'file_type' => 'embed']);
                }
            }
        }

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        Gate::authorize('delete', $project);
        
        // Hapus media terkait dari storage
        foreach ($project->media as $media) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * Submit project for review.
     */
    public function submitForReview(Project $project): RedirectResponse
    {
        Gate::authorize('update', $project);
        $project->update(['status' => 'pending_review']);
        return back()->with('success', 'Proyek telah diajukan untuk direview.');
    }

    /**
     * Preview a project.
     */
    public function preview(Project $project): View
    {
        Gate::authorize('update', $project);
        return view('portofolio.show', compact('project'));
    }
}
