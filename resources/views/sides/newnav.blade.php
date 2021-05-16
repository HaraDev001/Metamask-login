<div class="container la-topbar sticky-top mb-4 font-weight-bold">
    <div class="row">
        <div class="col-xl-2">
            <div class="image-group-inline">
                <image class="image-inline" src="./images/logo.png"/>
            </div>
        </div>
        <div class="col-xl-2"></div>
        <div class="col-xl-4">
            <div class="la-navbar">
                @if ($nav_type??null)
                <div class="la-navbar-item">
                    <a id = "artworks" class="btn {{$nav_type=='1'?'btn-dark':'btn-light'}}" href="/">Artworks</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn {{$nav_type=='2'?'btn-dark':'btn-light'}}" href="/arthome_new">Home</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn {{$nav_type=='3'?'btn-dark':'btn-light'}}" href="/creator_new">Creator</a>
                </div>
                @else
                <div class="la-navbar-item">
                    <a class="btn btn-dark" href="/">Artworks</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn btn-light" href="/arthome_new">Home</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn btn-light" href="/creator_new">Creator</a>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-md-2">
        <button id="wallet_btn" class="round-button-black">
            Connect Wallet
        </button>
    </div>
    </div>
    <div class="row">
        <div class="col-xl-4 pl-0">
            @if(@isset($nav_type)&&$nav_type==1)
            <div class="la-navbar-1">
                @if(@isset($type))
                <div class="la-navbar-item">
                    <a class="btn {{$type=='1'?'btn-dark':'btn-light'}}" href="/?&type=1">Live auction</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn {{$type=='2'?'btn-dark':'btn-light'}}" href="/?type=2">Reserve not met</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn {{$type=='3'?'btn-dark':'btn-light'}}" href="?type=3">Sold</a>
                </div>
                {{-- @else
                <div class="la-navbar-item">
                    <a class="btn btn-dark" href="/artworks?type=1">Live auction</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn btn-light" href="/artworks?type=2">Reserve not met</a>
                </div>
                <div class="la-navbar-item">
                    <a class="btn btn-light" href="artworks?type=3">Sold</a>
                </div> --}}
                @endif
            </div>
            @endif
        </div>
        {{-- <div class="col-xl-8 pl-0">
            <div class="la-navbar-1">
                <div class="la-navbar-item text-right">
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                    My account
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/account">Account</a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/signout">Singout</a>
                    </div>
                </div>
                    <!-- <a class="btn btn-light" href="artworks?type=3">My account</a> -->
                </div>
            </div>
        </div> --}}
    </div>
    <div class='line mt-2 border-dark pb-2'></div>
</div>