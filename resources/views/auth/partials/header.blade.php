<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>{{ env('APP_NAME') }}::@yield('title')</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Material icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- swiper CSS -->
    <link href="/vendor/swiper/css/swiper.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/style.css" rel="stylesheet" id="style">
    <link href="/css/style-gray.css" rel="stylesheet" id="style">
</head>

<body class="body-scroll d-flex flex-column h-100 menu-overlay">
    <!-- screen loader -->
    <div class="container-fluid h-100 loader-display">
        <div class="row h-100">
            <div class="align-self-center col">
                <div class="logo-loading">
                    <div class="icon icon-100 mb-4 rounded-circle">
                        <h4><span>Bitma</span><span class="text-primary">Traders</span></h4>
                    </div>
                    <h4 class="text-default">{{ env('APP_NAME') }}</h4>
                    <div class="loader-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Begin page content -->
    <main class="flex-shrink-0 main has-footer">
        <!-- Fixed navbar -->
        <header class="header">
            <div class="row">
                <div class="text-left col align-self-center">

                </div>
                <div class="ml-auto col-auto align-self-center">
                    @if (request()->routeIs('user.login') || request()->routeIs('user.terms'))
                        <a href="{{ route('user.register') }}" class="text-white">
                            Register
                        </a>
                    @elseif (request()->routeIs('user.register'))
                        <a href="{{ route('user.login') }}" class="text-white">
                            Login
                        </a>
                    @else
                        <a href="{{ route('user.login') }}" class="text-white">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </header>