@extends('layouts.app')
{{header('Authorization: Bearer $session("token")')}}
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
                    {{ $artworks }}
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container">


    <h3>Artworks. Please enjoy!</h3>
    {{-- @if(!empty(session('token')))
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
    @endif --}}

    <div class="row">
        <!-- <div class='list-group gallery'> -->


            @if($artworks->count())
                @foreach($artworks as $artwork)
                <div class='col-sm-3 col-xs-6 col-md-3 col-lg-3'>
                    {{-- {{$artwork}} --}}
                    <div class="image-height">
                        <a class="thumbnail" rel="ligthbox" href="javascript:artwork_id({{$artwork->id}})">
                            <img class="img-thumbnail p-0" alt="" src="/uploads/{{ $artwork->image }}" />
                            <div class='text-center'>
                                <span class='font-weight-bold'>{{ $artwork->title }}</span>
                            </div> <!-- text-center / end -->
                        </a>
                    </div>
                        <div class='mb-4 mt-4'>
                            <span class='text-muted'>bids: {{ $artwork->bids->count() }}</span>
                            <span class="float-right">
                            <span class='text-muted'>{{ $artwork->price.'eth' }}</span>
                            {{-- {{$artwork->firstbidtime}} --}}
                            {{-- {{$artwork->sold}} --}}
                            @if ($artwork->sold)
                                :Sold
                            @elseif ($artwork->bidable)
                                <button class="btn btn-dark pt-0 pb-0" onclick="form_art_bid('{{$artwork->id}}', '{{$artwork->price}}', '0x0fbd6e14566A30906Bc0c927a75b1498aE87Fd43')">Bid now</button>
                            @else
                                :Your Post
                            @endif
                            </span>
                            <!-- <button id="bid_btn" class="btn btn-success">bid</button> -->
                        </div> <!-- text-center / end -->
                        <div class="text-center time-count mt-4">
                        </div>
                    <!-- <form id="bid_form" action="{{ url('artwork/bid') }}" method="post">
                        @csrf
                        <input type="hidden" name="artwork_id" value="{{$artwork->id}}">
                        <input type='hidden' name="token" value="{{ Session::get('token') }}">
                    </form> -->

                    <!-- <form action="{{ url('artwork',$artwork->id) }}" method="POST">
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
