<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bot de la Girocleta')</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
    <style>
    
    </style>
</head>
<body>
<header>
    <a href="{{ route('home') }}" class="logo-title">
        <div class="logo">
            <img src="{{ url('img/bike.png') }}" alt="Girocleta Bike" width="100">
        </div>
        <h4 class="title">
            GIROCLETA<br>(Bot Telegram)
        </h4>
    </a>
    <nav class="menu">
        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="responsiveMenu()">&#9776;</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Sobre el projecte</a>
        <a href="{{ route('legal') }}" class="{{ request()->routeIs('legal') ? 'active' : '' }}">Informació legal</a>
        <a href="http://girocleta.cat" target="_blank">Web oficial de la Girocleta</a>
    </nav>
</header>
<div class="container mt-8 text-center mx-auto my-0 flex-1">
    @yield('content')
</div>

@yield('scripts')

<script>
    function responsiveMenu() {
        let x = document.querySelector(".menu");
        if (x.className === "menu") {
            x.className += " responsive";
        } else {
            x.className = "menu";
        }
    }
</script>
</body>
</html>