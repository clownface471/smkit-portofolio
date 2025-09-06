<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug', // Ditambahkan
        'category_id',
        'allowed_jurusan',
    ];

    protected $casts = [
        'allowed_jurusan' => 'array',
    ];

    /**
     * Automatically create a slug from the name.
     */
    protected static function booted(): void
    {
        static::creating(function (Tag $tag) {
            $tag->slug = Str::slug($tag->name);
        });

        static::updating(function (Tag $tag) {
            if ($tag->isDirty('name')) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
