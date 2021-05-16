<div>
	 
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<a class="localLink">testing token to localstorage
	</a>
	

<script>




confirm('testing script');
if(document.cookie){
		confirm(document.cookie);
}


function getCookie(name){
    var pattern = RegExp(name + "=.[^;]*")
    matched = document.cookie.match(pattern)
    if(matched){
       var cookie = matched[0].split('=')
        webToken = cookie[1];
	localStorage.setItem("token", webToken);	

    }
    return false
}
getCookie('token');	


tokenAuth = "Bearer " +  localStorage.getItem("token");
confirm(tokenAuth);

$( document ).ready(function() {

	$('.tokenProtected').on('click', function(){
	confirm('clicked');

	
	$.ajax({
		type: 'get',
		url: "http://127.0.0.1:8888/test",
		headers: {
			"Authorization": tokenAuth,
		 },
		 success: function(data) {
		    confirm(data);
		},			 
	});

   });
});


$( document ).ready(function() {
	$('.localLink').on('click', function(){
		// Access some stored data
	alert( "local data web token = " + localStorage.getItem("token"));
	
	});
});

</script>

</div>
