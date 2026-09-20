<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = [
        'album_id', 'original_name', 'path', 'thumbnail_path',
        'width', 'height', 'size',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }


    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }


    public function getThumbnailUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->thumbnail_path);
    }
    
}