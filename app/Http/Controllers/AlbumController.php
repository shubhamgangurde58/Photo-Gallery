<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Models\Album;
use App\Services\ImageService;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('coverPhoto')
            ->withCount('photos')
            ->latest()
            ->paginate(12);

        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(StoreAlbumRequest $request)
    {
        $album = Album::create($request->validated());

        return redirect()
            ->route('albums.show', $album)
            ->with('success', 'Album created. Now upload some photos!');
    }

    public function show(Album $album)
    {
        $photos = $album->photos()->paginate(24);

        return view('albums.show', compact('album', 'photos'));
    }

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(StoreAlbumRequest $request, Album $album)
    {
        $album->update($request->validated());

        return redirect()
            ->route('albums.show', $album)
            ->with('success', 'Album updated.');
    }

    public function destroy(Album $album, ImageService $images)
    {
        $images->deleteAlbumFolder($album);
        $album->delete(); // photos rows removed by cascade

        return redirect()
            ->route('albums.index')
            ->with('success', 'Album deleted.');
    }
}