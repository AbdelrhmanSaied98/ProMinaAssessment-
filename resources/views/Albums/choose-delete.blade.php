@extends('layouts.app')

@section('content')
    <div class="p-2">
        <a href="/albums" class="btn btn-secondary "><i class="bi bi-arrow-return-left"></i></a>
    </div>
    <div class="container p-5">
        <div class="col-12 text-center">
            <h5 class="p-2" > This Album has already some pictures </h5>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{url('/albums/'.$album->id.'/option')}}" class="text-center">
            @csrf
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">delete all the pictures in the album</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                <label class="form-check-label" for="inlineRadio2">move the pictures to another album</label>
            </div>

            <div class="col-12 text-center p-4">
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>

        </form>
    </div>

@endsection
