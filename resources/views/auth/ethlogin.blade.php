@extends('layouts.loginapp')

@section('content')
@push('head')
<!-- Styles -->
<!-- <link href="{{ asset('css/pizza.css') }}" rel="stylesheet"> -->
<!-- Scripts -->

@endpush
<div>

  <h1><strong>Welcome.</strong> Please sign in.</h1>

  <!-- <form action="#" method="get">

    <fieldset>

      <p><input type="text" required value="Username" placeholder="Username"></p>

      <p><input type="password" required value="Password" placeholder="Password"></p>

      <p><a href="#">Forgot Password?</a></p>

      <p><input type="submit" value="Login"></p>

    </fieldset>

  </form> -->

  <!-- <p><span class="btn-round">or</span></p> -->

  <p class="text-center">

    <a id="login_submit" class="metamask-before">
        <!-- <span class="fa fa-ethereum"></span> -->
        <!-- <span> -->
        <img class="metamask-img" src="/images/metamask-ethereum-online-wallet-logo-750x469.png"/>
        <!-- </span> -->
    </a>
    <button class="metamask">Sign In Using MetaMask</button>

  </p>

  <!-- <p>

    <a class="twitter-before"><span class="fontawesome-twitter"></span></a>
    <button class="twitter">Login Using Twitter</button>

  </p> -->

</div>
@endsection
