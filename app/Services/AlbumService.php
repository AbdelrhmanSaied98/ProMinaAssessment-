<?php

namespace App\Services;

use App\Http\Requests\StoreAlbumRequest;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumService
{
    public function index()
    {
        return Album::with('pictures')->get();
    }


    public function store(StoreAlbumRequest $request)
    {
        Album::create($request->validated());

    }

    public function destroy(Album $album)
    {
        $album->delete();
    }
}
