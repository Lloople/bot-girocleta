<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bot de la Girocleta')</title>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
<div class="container mt-8 text-center mx-auto my-0 flex-1">
    @yield('content')
    
    <footer>
        <a href="http://girocleta.cat" target="_blank">Web oficial de la Girocleta</a>
        |
        <a href="{{ route('about') }}">Sobre el projecte</a>
        |
        <a href="https://davidllop.com" target="_blank">Sobre el desenvolupador</a>
        |
        <a href="{{ route('legal') }}">Informació legal</a>
    </footer>
</div>

@yield('scripts')
</body>
</html>