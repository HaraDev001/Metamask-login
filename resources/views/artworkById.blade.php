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
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container">
    @if ($artwork)
    <div class='text-center'>
        <h3>{{$artwork->title}}</h3>
        <img src="/uploads/{{$artwork->image}}" alt="{{$artwork->title}}" class="mx-auto art_max_img">
    </div>
    
    <div class='text-right'>
        <small class='text-muted'>{{ $artwork->price.' eth' }}</small>
        <button class="btn btn-dark" onclick="form_art_bid('{{$artwork->id}}')">Bid now</button>
    </div>
    <h4>bids list</h4>
    @foreach ($bids as $bid)
        <li>{{ $bid->user->publicAddress }}</li>
    @endforeach
    @else
    <h4>There is nothing, Sorry!</h4>
    @endif


   
</div> <!-- container / end -->
@endsection
