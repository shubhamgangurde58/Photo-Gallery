<?php

namespace App\Services;

use App\Models\Album;

use App\Models\Photo;

use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    private const MAX_WIDTH = 1600;  

    private const THUMB_SIZE = 400;  

    public function store(Album $album, UploadedFile $file): Photo
    {
        $disk = Storage::disk('public');
        $name = Str::uuid() . '.webp';

        $path      = "albums/{$album->id}/{$name}";
        $thumbPath = "albums/{$album->id}/thumbs/{$name}";

        $image = Image::read($file)->scaleDown(width: self::MAX_WIDTH);

        $encoded = $image->toWebp(80);

        $disk->put($path, (string) $encoded);


        $thumb = Image::read($file)->cover(self::THUMB_SIZE, self::THUMB_SIZE);
        $disk->put($thumbPath, (string) $thumb->toWebp(75));

        return $album->photos()->create([
            'original_name'  => $file->getClientOriginalName(),
            'path'           => $path,
            'thumbnail_path' => $thumbPath,
            'width'          => $image->width(),
            'height'         => $image->height(),
            'size'           => $disk->size($path),
        ]);
    }

    public function delete(Photo $photo): void
    {
        Storage::disk('public')->delete([$photo->path, $photo->thumbnail_path]);

        $photo->delete();
    }

    public function deleteAlbumFolder(Album $album): void
    {
        Storage::disk('public')->deleteDirectory("albums/{$album->id}");

    }
}