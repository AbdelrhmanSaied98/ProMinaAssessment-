@extends('layouts.app')
@section('content')
    <div class="p-2">
        <a href="/albums" class="btn btn-secondary "><i class="bi bi-arrow-return-left"></i></a>
    </div>

    <div class="container p-5">
        <div class="col-12 text-center">
            <h3 class="p-2" > Edit on {{$album->name}} Album </h3>
        </div>

        <form action="{{url('dropzone/store/'.$album->id)}}" method="POST" enctype="multipart/form-data" id = "image-upload" class="dropzone">
            @csrf

        </form>

    </div>
        <script>
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(".dropzone",{
                addRemoveLinks: true,
                removedfile: function(file) {
                    console.log(file);
                    var name = file.name;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("/dropzone/delete/".$album->id) }}',
                        data: "filename="+name,
                        dataType: 'html'
                    });
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                acceptedFiles:'.jpeg, .jpg , .png, .gif',
                init: function() {
                    myDropzone = this;

                    $.ajax({
                        url: '{{ url("dropzone/index/".$album->id) }}',
                        type: 'get',
                        dataType: 'json',
                        success: function(response){

                            $.each(response, function(key,value) {
                                var mockFile = { name: value.name, size: value.size };

                                myDropzone.emit("addedfile", mockFile);
                                myDropzone.emit("thumbnail", mockFile, value.path);
                                myDropzone.emit("complete", mockFile);

                            });

                        }
                    });
                }
            });
        </script>
@endsection
