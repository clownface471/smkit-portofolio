<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Tag;

class PublicController extends Controller
{
    public function home()
    {
        // Ambil pengaturan dari DB
        $settings = Setting::pluck('value', 'key');

        $featuredProjects = Project::where('status', 'published')
                                ->where('is_featured', true)
                                ->with('user', 'media', 'tags')
                                ->latest()
                                ->get();

        $latestProjects = Project::where('status', 'published')
                               ->where('is_featured', false) // Ambil yang TIDAK featured
                               ->with('user', 'media', 'tags')
                               ->latest()
                               ->take(6)
                               ->get();

        return view('home', [
            'featuredProjects' => $featuredProjects,
            'latestProjects' => $latestProjects,
            'settings' => $settings // Kirim settings ke view
        ]);
    }

    public function gallery(Request $request)
    {
        $categories = Category::with('tags')->orderBy('name')->get();

        $tags = $categories->flatMap(function ($category) {
            return $category->tags;
        });

        $query = Project::where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        if ($request->filled('jurusan')) {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->where('jurusan', $request->jurusan);
            });
        }

        if ($request->filled('include_tags')) {
            $includeTags = $request->include_tags;
            $query->whereHas('tags', function ($q) use ($includeTags) {
                $q->whereIn('tags.id', $includeTags);
            });
        }

        if ($request->filled('exclude_tags')) {
            $excludeTags = $request->exclude_tags;
            $query->whereDoesntHave('tags', function ($q) use ($excludeTags) {
                $q->whereIn('tags.id', $excludeTags);
            });
        }

        $projects = $query->with('user', 'media', 'tags')
                        ->latest()
                        ->paginate(12)
                        ->withQueryString();

        return view('portofolio.gallery', compact('projects', 'tags', 'categories'));
    }
    public function show(Project $project): View
    {
        $project->load('user', 'media', 'tags');
        return view('portofolio.show', ['project' => $project]);
    }

    public function showSiswa(User $user)
    {
        $user->load(['projects' => function ($query) {
            $query->where('status', 'published')->latest();
        }]);

        return view('portofolio.siswa-show', compact('user'));
    }
}
