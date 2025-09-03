<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $projects = Project::where('status', 'pending_review')->latest()->get();

        return view('review.index', [
            'projects' => $projects,
        ]);
    }

    public function approve(Project $project): RedirectResponse
    {
        $project->status = 'published';
        $project->rejection_reason = null;
        $project->save();

        return redirect(route('review.index'))->with('success', 'Proyek berhasil disetujui dan dipublikasikan.');
    }

    public function reject(Request $request, Project $project): RedirectResponse
    {
        // Validasi input dari modal (aturan min:10 dihapus)
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // Kembalikan status menjadi 'draft' dan simpan alasan penolakan
        $project->status = 'draft';
        $project->rejection_reason = $validated['rejection_reason'];
        $project->save();

        return redirect(route('review.index'))->with('success', 'Proyek berhasil ditolak dan dikembalikan ke siswa.');
    }
}

