
{{-- {{header('Authorization: '.session('token'))}}
<body>
{{implode($_GET)}}
</body> --}}
{{-- {{header('Location: '.$_GET['artworks.blade.php'])}} // ... redirect to previously requested file}} --}}
 {{-- header('Location: /somefolder/' . $_GET['url']); // ... redirect to previously requested file --}}
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
{{-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
    <title>Document</title>
 </head>
 <body>
     <a id="hhh" href="/artworks">asdasd</a>
     <form id="get_form" action="{{ route('artworks') }}" method="get">
        @csrf
        <input id="get_form_input" type="hidden" name='token' value="">
    </form>
     <script>
        //  asd
        $(document).ready(function(){
            console.log($('a'));
            $('#get_form').submit();
        })
     </script>
 </body>
 </html>