<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Support\Str;

class Album extends Model
{
    protected $fillable = ['title', 'slug', 'description'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Album $album) {
            $album->slug = static::uniqueSlug($album->title);
        });
    }

    protected static function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'album';
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->latest();
    }

  
    public function coverPhoto(): HasOne
    {
        return $this->hasOne(Photo::class)->oldestOfMany();
    }
}