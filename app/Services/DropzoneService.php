<?php

namespace App\Services;

use App\Http\Requests\StoreFileRequest;
use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DropzoneService
{
    public function index(Album $album)
    {
        $directory = '/assets/pictures';
        $files_info = [];
        $file_ext = array('png','jpg','jpeg');


        foreach (File::allFiles(public_path($directory)) as $file)
        {
            $extension = strtolower($file->getExtension());

            if(in_array($extension,$file_ext)){
                $filename =  $file->getFilename();
                $picture = Picture::where('name',$filename)->first();
                if ($picture->album->id != $album->id)
                {
                    continue;
                }
                $size = $file->getSize();

                $files_info[] = array(
                    "name" => $filename,
                    "size" => $size,
                    "path" => url($directory.'/'.$filename)
                );
            }
        }
        return $files_info;
    }

    public function store(StoreFileRequest $request, Album $album)
    {
        $image  = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('/assets/pictures'),$imageName);
        Picture::create([
            'album_id' =>  $album->id,
            'name' =>  $imageName,
        ]);
        return $imageName;
    }

    public function destroy(Request $request, Album $album)
    {
        $filename =  $request->get('filename');
        Picture::where('name',$filename)->delete();
        $path =  public_path('/assets/pictures/'.$filename);
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
