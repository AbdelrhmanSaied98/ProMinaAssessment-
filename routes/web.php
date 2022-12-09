<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/albums');
});

Route::resource('albums', AlbumController::class);

Route::group([
    'prefix' => 'albums'
], function ($router) {
    Route::get('/{album}/check-delete', [AlbumController::class, 'checkDelete']);
    Route::post('/{album}/option', [AlbumController::class,'deleteOptions']);
    Route::post('/{album}/convert', [AlbumController::class,'convertAlbum']);

});

Route::group([
    'prefix' => 'dropzone'
], function ($router) {
    Route::get('/index/{album}', [AlbumController::class, 'readFiles'])->name('readFiles');
    Route::post('/store/{album}', [AlbumController::class,'saveFile'])->name('dropzone.store');
    Route::post('/delete/{album}', [AlbumController::class,'fileDestroy']);

});







