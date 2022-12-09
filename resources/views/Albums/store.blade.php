@extends('layouts.app')
@section('content')
        <div class="container p-5">
            <div class="col-12 text-center">
                <h3 class="p-2" > Add New Album </h3>
            </div>

            <form method="POST" enctype="multipart/form-data" action="{{url('/albums')}}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required="">
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
@endsection
