<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
// Pastikan 3 baris ini ada
use App\Mail\ProjectApproved;
use App\Mail\ProjectRejected;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function index()
    {
        $projects = Project::where('status', 'pending_review')
                            ->with('user')
                            ->latest()
                            ->paginate(10);

        return view('review.index', compact('projects'));
    }
    /**
     * Menampilkan halaman detail untuk satu proyek yang akan direview.
     */
    public function show(Project $project): View|RedirectResponse
    {
        if ($project->status !== 'pending_review') {
            return redirect(route('review.index'))->with('error', 'Proyek ini tidak lagi menunggu review.');
        }
        return view('review.show', ['project' => $project]);
    }

    public function approve(Request $request, Project $project): RedirectResponse
    {
        $request->validate(['confirmation' => 'required']);

        $project->status = 'published';
        $project->rejection_reason = null;
        $project->save();

        // ======================================================
        // PERUBAHAN: Kirim email notifikasi persetujuan
        Mail::to($project->user->email)->send(new ProjectApproved($project));
        // ======================================================

        return redirect(route('review.index'))->with('success', 'Proyek berhasil disetujui dan dipublikasikan.');
    }

    public function reject(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $project->status = 'draft';
        $project->rejection_reason = $validated['rejection_reason'];
        $project->save();

        // ======================================================
        // PERUBAHAN: Kirim email notifikasi penolakan
        Mail::to($project->user->email)->send(new ProjectRejected($project));
        // ======================================================

        return redirect(route('review.index'))->with('success', 'Proyek berhasil ditolak dan dikembalikan ke siswa.');
    }
}