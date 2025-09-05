<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'file_path',
        'file_type',
        'file_name', // <-- Tambahkan ini
        'embed_url', // <-- Dan tambahkan ini
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    /**
 * Get the full URL for the project media file.
 *
 * @return string
 */
    public function getFileUrlAttribute(): string
    {
        // Cek jika file_path ada dan bukan hanya placeholder untuk video embed
        if ($this->file_path && $this->file_path !== 'embed') {
            // Menggunakan Storage facade untuk mendapatkan URL yang benar dari disk 'public'
            return Storage::disk('public')->url($this->file_path);
        }

        // Fallback jika tidak ada gambar (seharusnya tidak terjadi jika logika di view benar)
        return 'https://placehold.co/600x400/004D40/FFFFFF?text=No+Image';
    }
}

