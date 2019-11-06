<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('title')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/fontawesome-v5.7.2.js') }}" defer></script></script>
    <script type="text/javascript">
    var toastrOptions = {
        positionClass: 'toast-bottom-right'
    }
    </script>
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <div id="app">
        <div class="content col-md-8 mx-auto no-padding">
            <div class="bg-dark text-white brand-heading text-center">
                Send Receive Temp Mails
            </div>
            <nav class="navbar navbar-expand-md bg-dark shadow-sm navbar-dark">
                <div class="container">
                    <!--
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>-->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item active">
                                <a class="nav-link text-white" href="{{url('/')}}">Inbox</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link text-white" href="{{url('/compose')}}">Compose</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link text-white" href="{{url('/add-domain')}}">Add Domain</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link text-white" href="{{url('/contact-us')}}">Contact us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="">
                @yield('content')
            </main>
            <nav class="navbar navbar-expand-md bg-dark shadow-sm" style="margin-top: auto;">
                <div class="container">
                    <a class="navbar-brand text-white" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link text-white" href="{{url('#')}}">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</body>
</html>
