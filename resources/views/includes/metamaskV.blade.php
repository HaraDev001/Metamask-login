<!-- <script src="node_modules/web3/dist/web3.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 

<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.3.5/web3.min.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src = "https://unpkg.com/ethereumjs-util@7.0.3/"></script>
<script src = "https://www.jsdelivr.com/package/npm/@types/eth-sig-util/"></script>
<script>
	$(document).ready(function(){
	const ethUtil = window.ethUtil;
	const sigUtil = window.sigUtil;

	// import ethUtil from 'ethereumjs-util'
	// import sigUtil from 'eth-sig-util'
	// import Web3 from '/node_modules/web3/dist/web3.min.js';
	const handleClick = async () => {
		// Check if MetaMask is installed
		if (!ethereum) {
			// alert('Please install MetaMask first.');
			$("#myModal").modal('show');
			return;
		}
		$("#myModal2").modal('show');
	}
	const handleClick2 = async () => {
		// Check if MetaMask is installed
		// if (!ethereum) {
		// 	// alert('Please install MetaMask first.');
			$("#myModal2").modal('hide');
		// 	return;
		// }

		if (web3) {
			try {
				// Request account access if needed
				await window.ethereum.request({ method: 'eth_requestAccounts' });

				// We don't know window.web3 version, so we use our own instance of Web3
				// with the injected provider given by MetaMask
				web3 = new Web3((window).ethereum);
			} catch (error) {
				// window.alert('You need to allow MetaMask.');
				
				// (window).ethereum.close()
				return;
			}
		}
		const coinbase = await web3.eth.getCoinbase().then(coinbase=>{
			console.log(coinbase);
			if (!coinbase) {
				window.alert('Please activate MetaMask first.');
				return;
			}
			
			const publicAddress = coinbase.toLowerCase();
			// console.log(publicAddress);
		// setLoading(true);

		// Look if user with current publicAddress is already present on backend
			// $.ajax({
			// 	type:'POST',
			// 	url:'/getmsg',
			// 	success:function(data) {
			// 		$("#msg").html(data.msg);
			// 	}
			// });	
			const requestOptions = {
				method: 'POST',
				headers: {
						'Content-Type': 'application/json',
						"X-CSRF-Token": '{{ csrf_token()}}'
					},
					// '_token':'{{ csrf_token()}}',
				body: JSON.stringify({ publicAddress: publicAddress })
				};

			fetch(
				'/user', requestOptions
			)
			.then(response => response.json() )
			// If yes, retrieve it. If no, create it.
			.then((user) =>{
				// console.log(publicAddress);
				console.log(Object.keys(user).length ? "signin" : "signup");
				return Object.keys(user).length ? user : handleSignup(publicAddress)
			})
			// Popup MetaMask confirmation modal to sign message
			.then(handleSignMessage)
			// Send signature to backend on the /auth route
			.then(handleAuthenticate)
			// Pass accessToken back to parent component (to save it in localStorage)
			.then(onLoggedIn)
			.catch((err) => {
				console.log(err);
				// setLoading(false);
			});
		});

		
	}

	const handleSignup = publicAddress =>
		fetch(`/signup`, {
		body: JSON.stringify({ publicAddress }),
		headers: {
			'Content-Type': 'application/json',
			"X-CSRF-Token": '{{ csrf_token()}}'
		},
		method: 'POST'
	}).then(response => {return response.json()})

	const handleSignMessage = ({ publicAddress, nonce }) => {
		// const msgParams = [
		// 	{
		// 	type: 'string',
		// 	name: 'Message',
		// 	value: 'Hi, Alice!'
		// 	},
		// 	{
		// 	type: 'uint32',
		// 	name: 'A number',
		// 	value: '1337'
		// 	}
		// ]
		const from = publicAddress;
		const text = `I am signing my one-time nonce: ${nonce}`
		// const msg = ethUtil.bufferToHex(new Buffer(text, 'utf8'))
		const msg = web3.utils.fromUtf8(`I am signing my one-time nonce: ${nonce}`)
		const params = [msg, from]
		const method = 'personal_sign'
		console.log(from);
		return new Promise((resolve, reject) =>
			web3.currentProvider.sendAsync(
				{
					method,
					params,
					from,
				},
				// web3.utils.fromUtf8(`I am signing my one-time nonce: ${nonce}`),
				// publicAddress,
				(err, result) => {
					if (err) {
						console.log('Sign error, please connect your blockchain.')
						return reject(err)
					}
					if (result.error) {
						alert('Error occured on your blockchain.');
						return console.error(result.error);
					}
					console.log('PERSONAL SIGNED:' + JSON.stringify(result.result))
					console.log('recovering...')
					const msgParams = { data: msg }
					msgParams.sig = result.result
					console.dir({ msgParams })
					return resolve({ publicAddress });
				})
		);
	};

	const getCookie = name => {
		var cookieArr = document.cookie.split(";");
		for(var i = 0; i < cookieArr.length; i++) {
			var cookiePair = cookieArr[i].split("=");
			if(name == cookiePair[0].trim()) {
				return decodeURIComponent(cookiePair[1]);
			}
		}
		return null;
	}

	const handleAuthenticate = ({ publicAddress, signature }) =>
			fetch(`/metaauth`, {
			body: JSON.stringify({ publicAddress, signature }),
			headers: {
				'Content-Type': 'application/json',
				"X-CSRF-Token": '{{ csrf_token()}}'
			},
			method: 'POST'
		}).then(response => {return response.json();});

	const onLoggedIn = (res) => {
		// console.log('{{ session('token') }}');
		// var myRequest = new Request("http://localhost/artworks","GET");
		// var exchange = httpClient.send(myRequest);
		console.log("res.token");
		// $('#login_token').val(res.token);
		// alert(res.token)

		// document.location = '/artworks?token='+res.token;
		// $.post( "/artworks_confirm",{token: res.token, _token: '{{csrf_token()}}'}, function( data ) {
		// 	console.log(data);
		// 	// document.location = "/artworks"
		// });

		$('#get_form_input').val(res.token);
		$('#get_form').submit();
		// console.log($('#get_form'));
	}

	$("#login_submit, #wallet_btn").on("click", handleClick);
	$("#login_submit2").on("click", handleClick2);


	// web3.eth.getAccounts(function(error, accounts) {
	// 	if (accounts.length > 0) {
	// 	  confirm('metaUserLogged!!!');
		
	// 	var valuePost = accounts[0];
	// 	confirm(valuePost); 
	
	// document.body.innerHTML += '<form id="ethm"  method="post"><input id="ethidinput" type="hidden" name="ethid" value="www"></form>';

	// document.getElementById('ethm').action = urlA;	

	// document.getElementById("ethidinput").value = valuePost;

	// document.getElementById("ethm").submit();

	//  }
	
	});
</script>
