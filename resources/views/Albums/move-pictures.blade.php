@extends('layouts.app')

@section('content')

    <div class="container p-5">
        <div class="col-12 text-center">
            <h5 class="p-2" > Choose another album </h5>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{url('/albums/'.$album->id.'/convert')}}" class="text-center">
            @csrf
            <select class="form-select" name="new_album">
                @foreach($albums as $key=>$value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach


            </select>



            <div class="col-12 text-center p-4">
                <button type="submit" class="btn btn-primary">Convert</button>
            </div>

        </form>
    </div>

@endsection
