<?php

namespace App\Http\Controllers;

use App\DataTables\AlbumsDataTable;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\StoreFileRequest;
use App\Models\Album;
use App\Models\Picture;
use App\Services\AlbumService;
use App\Services\DropzoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlbumController extends Controller
{
    private AlbumService $albumService;
    private DropzoneService $dropzoneService;

    public function __construct(AlbumService $albumService,DropzoneService $dropzoneService)
    {
        $this->albumService = $albumService;
        $this->dropzoneService = $dropzoneService;
    }

    public function index(AlbumsDataTable $dataTable)
    {
        $albums = Album::withCount('pictures')->get();
        $labelArray = [];
        $dataArray = [];
        foreach ($albums as $album)
        {
            $labelArray [] = $album->name;
            $dataArray [] = $album->pictures_count;
        }
        return $dataTable->render('Albums.index',['labelArray' =>$labelArray,'dataArray' =>$dataArray]);
    }

    public function create()
    {
        return view('Albums.store');
    }

    public function store(StoreAlbumRequest $request,AlbumsDataTable $dataTable)
    {
        $this->albumService->store($request);
        return redirect('/albums');

    }

    public function edit(Album $album)
    {
        return view('Albums.edit',['album' => $album]);
    }


    public function saveFile(StoreFileRequest $request, Album $album)
    {
        $fileName = $this->dropzoneService->store($request,$album);
        return response()->json(['Success' => $fileName]);
    }

    public function fileDestroy(Request $request, Album $album)
    {
        return $this->dropzoneService->destroy($request,$album);
    }

    public function readFiles(Album $album){
        $files_info = $this->dropzoneService->index($album);
        return response()->json($files_info);
    }

    public function checkDelete(Request $request, Album $album)
    {
        if (count($album->pictures) == 0)
        {
            $this->albumService->destroy($album);
            return redirect('/albums');
        }else
        {
            return view('Albums.choose-delete',['album' => $album]);
        }
    }

    public function deleteOptions(Request $request, Album $album)
    {
        if ($request->inlineRadioOptions == 'option1')
        {
            foreach ($album->pictures as $picture)
            {
                $path =  public_path('/assets/pictures/'.$picture->name);
                $image_path = $path;
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $this->albumService->destroy($album);
            return redirect('/albums');
        }else
        {
            $albums = Album::with('pictures')->where('id','!=',$album->id)->get();
            return view('Albums.move-pictures',['albums' => $albums,'album' => $album]);
        }
    }

    public function convertAlbum(Request $request, Album $album)
    {
        if ($request->new_album)
        {
            foreach ($album->pictures as $picture)
            {
                $picture->album_id = $request->new_album;
                $picture->save();
            }
            $album->delete();
            return redirect('/albums');
        }
    }


}
