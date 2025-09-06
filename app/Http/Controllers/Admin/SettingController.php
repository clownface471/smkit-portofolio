<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index(): View
    {
        // Ambil semua settings dari database dan ubah menjadi format yang mudah diakses di view
        // Contoh: ['hero_title' => 'Isi Judul', 'hero_subtitle' => 'Isi Subjudul']
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the specified settings in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500',
        ]);

        // Looping melalui data yang divalidasi dan simpan ke database
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
