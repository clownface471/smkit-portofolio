<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Menyimpan komentar baru ke database.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        // 1. Validasi input
        $request->validate([
            'body' => 'required|string|max:2500',
        ]);

        // 2. Buat komentar baru
        $project->comments()->create([
            'user_id' => Auth::id(), // ID pengguna yang sedang login
            'body' => $request->body,
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}