<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:image" content="{{ asset('storage/img/1419281141_363179.ico') }}" />
        <meta property="og:title" content="Grooki" />
        <meta property="og:description" content="Grooki магазин детской одежды" />
        @section('stylesheets')
        	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
            <link href="{{ asset('css/language.css') }}" rel="stylesheet">
        @show
        <title>Grooki</title>
        
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/img/1419281141_363179.ico') }}" />
    </head>
    <body>
        @section('body')
            @section('header')
            	@include('frontend/common_header')
            @show
            @yield('small_bag')
            @yield('content')
        @show
        @section('footer')
        	@include('frontend/common_footer')
        @show
        @section('javascripts')
            
        @show
    </body>
</html>
