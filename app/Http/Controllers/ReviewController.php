<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Menampilkan halaman daftar proyek yang perlu direview.
     */
    public function index(): View
    {
        // Ambil semua proyek yang statusnya 'pending_review', urutkan dari yang terbaru
        $projects = Project::where('status', 'pending_review')->latest()->get();

        return view('review.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Menyetujui sebuah proyek.
     */
    public function approve(Project $project): RedirectResponse
    {
        // Ubah status menjadi 'published'
        $project->status = 'published';
        $project->rejection_reason = null; // Hapus alasan penolakan jika ada
        $project->save();

        return redirect(route('review.index'))->with('success', 'Proyek berhasil disetujui dan dipublikasikan.');
    }

    /**
     * Menolak sebuah proyek.
     */
    public function reject(Project $project): RedirectResponse
    {
        // Kembalikan status menjadi 'draft' agar bisa diedit lagi oleh siswa
        $project->status = 'draft';
        $project->rejection_reason = 'Proyek ditolak. Silakan perbaiki lagi dan ajukan kembali. Hubungi guru pembimbing untuk detail lebih lanjut.';
        $project->save();

        return redirect(route('review.index'))->with('success', 'Proyek berhasil ditolak dan dikembalikan ke siswa.');
    }
}

