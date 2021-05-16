<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token" content="{{ session('token') }}">

    <title>{{ config('app.name', 'ArtWorld') }}</title>
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

<!-- References: https://github.com/fancyapps/fancyBox -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen"> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script> --}}

    <style type="text/css">
    .gallery
    {
        display: inline-block;
        margin-top: 20px;
    }
    .close-icon{
    	border-radius: 50%;
        position: absolute;
        right: 5px;
        top: -10px;
        padding: 5px 8px;
    }
    .form-image-upload{
        background: #e8e8e8 none repeat scroll 0 0;
        padding: 15px;
    }
    </style>

</head>
<body>
    <div id="app">
        @include('sides.newnav')
        <div>
            @yield('content')
        </div>
    </div>
    <form id="artwork_get_form" action="{{ route('artwork_id_new') }}" method="get">
        @csrf
        <input type="hidden" name='token' value="{{ Session::get('token') }}">
        <input id="artwork_id_input" type="hidden" name='art_id' value="">
    </form>
    <form id="form_art_bid" action="{{ route('bidart') }}" method="post">
        @csrf
        <input type="hidden" name='token' value="{{ Session::get('token') }}">
        <input id='artwork_id' type="hidden" name='artwork_id' value="{{ $artwork->id??'' }}">
        
    </form> 
    <footer class="text-center pr-4 pb-4">
        <div class="la-navbar-item">
            <a id="login_submit" class="btn btn-dark" href="#">Become a sellter</a>
        </div>
    </footer>
    <div class="bs-example">
        <div id="myModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">first install metamask</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Do you want to install metamask, then click the below button?</p>
                        {{-- <p class="text-secondary"><small>If you don't save, your changes will be lost.</small></p> --}}
                        {{-- <div class="modal-footer"> --}}
                        <a type="button" onclick="connectmetamask()" class="btn btn-dark" target="_blank" href="https://metamask.io/">Go to MetaMask's Website</a>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bs-example">
        <div id="myModal2" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Connect your wallet</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <p></p>
                        {{-- <p class="text-secondary"><small>If you don't save, your changes will be lost.</small></p> --}}
                        {{-- <div class="modal-footer"> --}}
                        <p class="text-center">

                            <a class="metamask-before">
                                <!-- <span class="fa fa-ethereum"></span> -->
                                <!-- <span> -->
                                <img class="metamask-img" src="/images/metamask-ethereum-online-wallet-logo-750x469.png"/>
                                <!-- </span> -->
                            </a>
                            <button id="login_submit2" class="metamask">MetaMask</button>
                        
                            </p>
                        {{-- <a type="button" onclick="connectmetamask()" class="btn btn-dark" target="_blank" href="https://metamask.io/">Go to MetaMask's Website</a> --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <form id="get_form" action="{{ route('artworks') }}" method="get">
        @csrf
        <input id="get_form_input" type="hidden" name='token' value="">
    </form> 
    <!-- Scripts -->
    @include('includes.metamaskV')
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- <script type="module"  src="{{ asset('js/components/ethlogin.js')}}"></script> -->
        <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.3.5/web3.min.js"></script>
        
        <script type="text/javascript">

            // const signup = () => {
            //     handleClick()
            // }
            const connectmetamask = () => {
                $("#myModal").modal('hide');
            }

            const artwork_id = (id) => {
                $('#artwork_id_input').val(id)
                $('#artwork_get_form').submit()
            }

            //transaction
            // function startProcess() {
            //     if ($('#inp_amount').val() > 0) {
            //         // run metamsk functions here
            //         EThAppDeploy.loadEtherium();
            //     } else {
            //         alert('Please Enter Valid Amount');
            //     }
            // }


            EThAppDeploy = {
                loadEtherium: async (id, amount, artwork_poster) => {
                    if (typeof window.ethereum !== 'undefined') {
                        EThAppDeploy.web3Provider = ethereum;
                        EThAppDeploy.requestAccount(ethereum, artwork_poster);
                    } else {
                        alert(
                            "Not able to locate an Ethereum connection, please install a Metamask wallet"
                        );
                    }
                },
                /****
                 * Request A Account
                 * **/
                requestAccount: async (ethereum, artwork_poster) => {
                    ethereum
                        .request({
                            method: 'eth_requestAccounts'
                        })
                        .then((resp) => {
                            //do payments with activated account
                            EThAppDeploy.payNow(ethereum, resp[0], artwork_poster);
                        })
                        .catch((err) => {
                            // Some unexpected error.
                            console.log(err);
                            alert(err.toString())
                        });
                },
                /***
                 *
                 * Do Payment
                 * */
                payNow: async (ethereum, from, artwork_poster) => {
                    var amount = amount;
                    ethereum
                        .request({
                            method: 'eth_sendTransaction',
                            params: [{
                                from: from,
                                to: artwork_poster,
                                value: '0x' + ((amount * 10).toString(16)),
                                data: '0x7f7465737432000000000000000000000000000000000000000000000000000000600057'
                            }, ],
                        })
                        .then((txHash) => {
                            if (txHash) {
                                console.log(txHash);
                                $('#artwork_id').val(id)
                                $('#form_art_bid').submit()
                                //Store Your Transaction Here
                            } else {
                                console.log("Something went wrong. Please try again");
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                },
            }

            // using the promise
            

            const form_art_bid = (id, price, artwork_poster)=> {
                if(confirm("Are you really bidding now?")){
                    EThAppDeploy.loadEtherium(id, price);
                    //
                //     if (web3) {
                //     try {
                //         // Request account access if needed
                //         // await window.ethereum.request({ method: 'eth_requestAccounts' });

                //         // We don't know window.web3 version, so we use our own instance of Web3
                //         // with the injected provider given by MetaMask
                //         web3 = new Web3((window).ethereum);
                //     } catch (error) {
                //         window.alert('You need to allow MetaMask.');
                //         // (window).ethereum.close()
                //         return;
                //     }
                // }
                //     web3.eth.sendTransaction({
                //         from: '86508f3dCFBF066C01321e0342Bfc222fCd84ED7',
                //         to: '0fbd6e14566A30906Bc0c927a75b1498aE87Fd43',
                //         value: '1000000000000000'
                //     })
                //     .then(function(receipt){
                //         alert('success')
                //         $('#artwork_id').val(id)
                //         $('#form_art_bid').submit()
                //     });
                }
            }
            
            let artworks = 0;
            @if (isset($artworks))
                artworks = {!!$artworks!!}
            @endif
            console.log(artworks);
            let firstbidtimes = [];
            @if(isset($firstbidtimes))
                firstbidtimes = {!!$firstbidtimes!!}
            @endif
            console.log(firstbidtimes);
            $(document).ready(function(){
                const message = '{{ Session::get('message') }}';
                if(message){
                    alert(message)
                }
                else{
                    const session_message = '{{ Session::get('message') }}';
                    if(session_message){
                        alert(session_message)
                    }
                }
                const bid_timers = $('.time-count');
                console.log(bid_timers);
                console.log('here',artworks[0]);
                if(bid_timers.length){
                    setInterval(() => {
                        const current_time = new Date().getTime();
                        bid_timers.map((index, bid_timer)=>{
                            console.log(bid_timer);
                            console.log(index);
                            console.log(artworks[index]);
                            if(firstbidtimes[index]){
                                const created_time = new Date(firstbidtimes[index]);
                                const time_limit = 86400 - (current_time - created_time.getTime());
                                const time_limit_format = new Date(time_limit);
                                console.log(time_limit);
                                if(time_limit>0){
                                    console.log(time_limit_format);
                                    let hours = time_limit_format.getHours();
                                    if(hours<10) hours = '0'+hours;
                                    let minutes = time_limit_format.getMinutes();
                                    if(minutes<10) minutes = '0'+minutes;
                                    let seconds = time_limit_format.getSeconds();
                                    if(seconds<10) seconds = '0'+seconds;
                                    $(bid_timer).text(hours+':'+minutes+':'+seconds);
                                }
                                else{
                                    $(bid_timer).text('ended');
                                }
                            }
                            else
                                $(bid_timer).text('not bidded');
                        })
                    }, 1000);
                }
            });

            

        </script>


</body>
</html>
