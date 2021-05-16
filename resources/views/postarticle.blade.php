@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center mt-5">
            {{-- @if(!empty(session('token'))) --}}
            <form action="{{ route('artworkpost') }}" class="form-image-upload mb-3" method="POST" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name="token" value="{{ Session::get('token') }}">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
                @endif --}}


                <div class="row">
                    <div class="col-md-3">
                        <strong>Title:</strong>
                        <input type="text" name="title" class="form-control" placeholder="Title">
                    </div>
                    <div class="col-md-3">
                        <strong>Price:</strong>
                        <input type="text" name="price" class="form-control" placeholder="Price">
                    </div>
                    <div class="col-md-3">
                        <strong>Image:</strong>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <br/>
                        <button type="submit" class="btn btn-dark">Post</button>
                    </div>
                </div>


            </form> 
            {{-- @endif --}}
        </div>
    </div>
@endsection