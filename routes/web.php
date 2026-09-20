<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/albums');

Route::resource('albums', AlbumController::class);

Route::post('albums/{album}/photos', [PhotoController::class, 'store'])
    ->name('albums.photos.store');

Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])
    ->name('photos.destroy');