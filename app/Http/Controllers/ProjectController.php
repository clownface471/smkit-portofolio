<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->with('media')->latest()->get();
        return view('projects.index', ['projects' => $projects]);
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $isRpl = $user->jurusan === 'RPL';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'github_url' => [$isRpl ? 'required' : 'nullable', 'url'],
            'demo_url' => 'nullable|url',
            'embed_url' => 'nullable|url',
            'source_url' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_type' => 'nullable|string|in:none,upload,embed',
            'video_upload' => [Rule::requiredIf($request->video_type === 'upload'), 'nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:20480'],
            'video_embed_url' => [Rule::requiredIf($request->video_type === 'embed'),'nullable','url'],
        ]);

        $projectData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'github_url' => $validated['github_url'] ?? null,
            'demo_url' => $validated['demo_url'] ?? null,
            'embed_url' => $validated['embed_url'] ?? null,
            'source_url' => $validated['source_url'] ?? null,
        ];
        
        $project = $request->user()->projects()->create($projectData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('project-images', 'public');
                $project->media()->create(['file_path' => $path, 'file_name' => $image->getClientOriginalName(), 'file_type' => 'image']);
            }
        }

        if ($request->video_type === 'upload' && $request->hasFile('video_upload')) {
            $video = $request->file('video_upload');
            $path = $video->store('project-videos', 'public');
            $project->media()->create(['file_path' => $path, 'file_name' => $video->getClientOriginalName(), 'file_type' => 'video_upload']);
        } elseif ($request->video_type === 'embed' && $request->filled('video_embed_url')) {
            $project->media()->create(['file_path' => 'embed', 'file_name' => 'embed_link', 'embed_url' => $request->video_embed_url, 'file_type' => 'video_embed']);
        }

        return redirect(route('projects.index'))->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function edit(Request $request, Project $project): View
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }
        return view('projects.edit', ['project' => $project->load('media')]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        $user = Auth::user();
        $isRpl = $user->jurusan === 'RPL';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'github_url' => [$isRpl ? 'required' : 'nullable', 'url'],
            'demo_url' => 'nullable|url',
            'embed_url' => 'nullable|url',
            'source_url' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_media' => 'nullable|array',
            'delete_media.*' => 'integer|exists:project_media,id',
            'video_type' => 'nullable|string|in:none,upload,embed',
            'video_upload' => [Rule::requiredIf($request->video_type === 'upload'), 'nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:20480'],
            'video_embed_url' => [Rule::requiredIf($request->video_type === 'embed'), 'nullable', 'url'],
        ]);

        // Hapus media lama yang dipilih
        if (!empty($validated['delete_media'])) {
            $mediaToDelete = ProjectMedia::whereIn('id', $validated['delete_media'])->where('project_id', $project->id)->get();
            foreach($mediaToDelete as $media) {
                if ($media->file_type !== 'video_embed' && $media->file_path !== 'embed') {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }
        }

        // Tambah gambar baru
        if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                $path = $image->store('project-images', 'public');
                $project->media()->create(['file_path' => $path, 'file_name' => $image->getClientOriginalName(), 'file_type' => 'image']);
            }
        }

        // Handle video baru (jika ada)
        // Hapus video lama dulu jika ada video baru yang di-submit
        if ($request->video_type === 'upload' || $request->video_type === 'embed') {
            $oldVideo = $project->media()->where('file_type', 'like', 'video_%')->first();
            if ($oldVideo) {
                 if ($oldVideo->file_type === 'video_upload') {
                    Storage::disk('public')->delete($oldVideo->file_path);
                }
                $oldVideo->delete();
            }
        }
        
        // Simpan video baru
        if ($request->video_type === 'upload' && $request->hasFile('video_upload')) {
            $video = $request->file('video_upload');
            $path = $video->store('project-videos', 'public');
            $project->media()->create(['file_path' => $path, 'file_name' => $video->getClientOriginalName(), 'file_type' => 'video_upload']);
        } elseif ($request->video_type === 'embed' && $request->filled('video_embed_url')) {
            $project->media()->create(['file_path' => 'embed', 'file_name' => 'embed_link', 'embed_url' => $request->video_embed_url, 'file_type' => 'video_embed']);
        }

        // Update data teks proyek
        $project->update($validated);

        return redirect(route('projects.index'))->with('success', 'Proyek berhasil diperbarui!');
    }
    
    public function destroy(Request $request, Project $project): RedirectResponse
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }
        foreach ($project->media as $media) {
            if ($media->file_type !== 'video_embed' && $media->file_path !== 'embed') {
                Storage::disk('public')->delete($media->file_path);
            }
        }
        $project->delete();
        return redirect(route('projects.index'))->with('success', 'Proyek berhasil dihapus!');
    }

    public function preview(Request $request, Project $project): View
    {
        $user = $request->user();
        // Izinkan guru/admin untuk melihat preview juga
        if ($user->role === 'siswa' && $project->user_id !== $user->id) {
            abort(403);
        }

        return view('projects.preview', ['project' => $project]);
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