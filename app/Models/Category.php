<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });
    }
}