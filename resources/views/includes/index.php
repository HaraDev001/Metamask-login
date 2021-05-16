<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>

 <script src="./node_modules/web3/dist/web3.min.js"></script> 
</head>
<body>

<h1>This is a Heading</h1>
<p>This is a paragraph.</p>
<div id="meta-mask-required"></div>

<script>

window.addEventListener('load', function() {

  // Check if Web3 has been injected by the browser:
  if (typeof web3 !== 'undefined') {
    // You have a web3 browser! Continue below!
	 web3js = new Web3(web3.currentProvider);
	  account = web3.eth.accounts[0];
	//console.log(account);
	// startApp(web3);
	  // Now you can start your app & access web3 freely:
 	// startApp();
	web3.eth.getAccounts(function(error, accounts) {
   		console.log(accounts);   
			if(){
			
		}
	});

  } else {
     // Warn the user that they need to get a web3 browser
     // Or install MetaMask, maybe with a nice graphic.
	confirm('NONweb3');
  }
	
	   

})



</script>

</body>
</html>
