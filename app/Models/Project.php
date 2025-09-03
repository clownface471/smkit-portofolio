<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Tambahkan baris ini
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'github_url',
        'demo_url',
        'figma_url',
    ];

    // Tambahkan fungsi ini
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
