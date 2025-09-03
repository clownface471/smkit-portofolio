<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Menampilkan daftar semua proyek untuk admin.
     */
    public function index(): View
    {
        $projects = Project::with('user')
                            ->latest()
                            ->paginate(15);

        return view('admin.projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Menarik kembali (unpublish) sebuah proyek.
     */
    public function retract(Project $project): RedirectResponse
    {
        $project->status = 'draft';
        $project->rejection_reason = 'Proyek ditarik oleh Administrator.';
        $project->save();

        return redirect(route('admin.projects.index'))->with('success', 'Proyek berhasil ditarik dari halaman publik.');
    }
}