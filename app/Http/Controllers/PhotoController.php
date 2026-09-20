<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotosRequest;
use App\Models\Album;
use App\Models\Photo;
use App\Services\ImageService;

class PhotoController extends Controller
{
    public function store(StorePhotosRequest $request, Album $album, ImageService $images)
    {
        foreach ($request->file('photos') as $file) {
            $images->store($album, $file);
        }

        return back()->with('success', count($request->file('photos')) . ' photo(s) uploaded.');
    }

    public function destroy(Photo $photo, ImageService $images)
    {
        $album = $photo->album;
        $images->delete($photo);

        return redirect()
            ->route('albums.show', $album)
            ->with('success', 'Photo deleted.');
    }
}