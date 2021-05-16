@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    {{-- {{ $artworks }} --}}
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container">


    <h3>Your bids</h3>
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


        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif


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


    <div class="row">
        <!-- <div class='list-group gallery'> -->
            @if($bids->count())
                @foreach($bids as $bid)
                <div class='col-sm-3 col-xs-6 col-md-3 col-lg-3'>
                    <div class="image-height">
                        <a class="thumbnail" rel="ligthbox" href="javascript:artwork_id({{$bid->artwork->id}})">
                            <img class="img-thumbnail p-0" alt="" src="/uploads/{{ $bid->artwork->image }}" />
                            <div class='text-center mb-1'>
                                <span class='font-weight-bold'>{{ $bid->artwork->title }}</span>
                            </div> <!-- text-center / end -->
                        </a>
                    </div>
                    {{-- <div class='text-left mb-4'>
                    
                    </div> --}}
                    <div class='mb-4 mt-2'>
                        <span class='text-muted mr-0'>other bids: {{$bid->artwork->bids->count()-1}}</span>
                        <span class='text-muted float-right'>{{ $bid->artwork->price.'eth' }}</span>
                    </div> <!-- text-center / end -->
                    @if($bid->artwork->sold)
                        <div class="text-center mt-4">
                            sold
                        </div>
                    @else
                        <div class="text-center time-count mt-4">
                        </div>
                    @endif
                    {{-- @if ($bid->artwork->bidable)
                        <button class="btn btn-dark" onclick="form_art_bid('{{$bid->artwork->id}}')">Bid now</button>
                    @else
                        :Your Post
                    @endif --}}
                        <!-- <button id="bid_btn" class="btn btn-success">bid</button> -->
                <!-- <form id="bid_form" action="{{ url('artwork/bid') }}" method="post">
                    @csrf
                    <input type="hidden" name="artwork_id" value="{{$bid->artwork->id}}">
                    <input type='hidden' name="token" value="{{ Session::get('token') }}">
                </form> -->

                <!-- <form action="{{ url('artwork',$bid->artwork->id) }}" method="POST">
                    <input type="hidden" name="_method" value="delete">
                    {!! csrf_field() !!}
                    <button type="submit" class="close-icon btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                </form> -->
            </div> <!-- col-6 / end -->
            @endforeach
        @else
            There is nothing, Sorry!
        @endif

        <!-- </div> list-group / end -->
    </div> <!-- row / end -->
</div> <!-- container / end -->
@endsection
