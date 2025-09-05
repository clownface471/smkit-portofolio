<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'jurusan',
        'github_url',
        'demo_url',
        'embed_url',
        'source_url',
        'rejection_reason',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // Tampilkan komentar terbaru dulu
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

