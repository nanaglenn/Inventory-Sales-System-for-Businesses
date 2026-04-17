<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .hidden-items {
            height: 0px !important;
            margin: 0;
            padding: 0;
        }

        .overlay {
            padding-top: 20px;
            position: fixed;
            display: none;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.9);
            z-index: 2;
            overflow-y: scroll;
            padding-bottom: 20px;
        }

        .close-overlay{
            position: absolute;
            right: 0;
            /* left: 0; */
            top: -15px;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(\Illuminate\Support\Facades\Auth::user()->access_level === "Administrator")
                                        <a class="dropdown-item" href="{{ url('/add-user') }}">
                                           Add New User
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/get-users') }}">
                                            Users List
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/add-stock') }}">
                                            Add Stock
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/add-new-item') }}">
                                            Add New Item
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/get-stock') }}">
                                            Check Inventory
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/get-sales-records') }}">
                                            Sales Records
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/system-alerts') }}">
                                           <small id="alert-count" style="color: red !important;">1</small> Alert(s)
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/check-out') }}">
                                            Check Out
                                        </a>
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->access_level === "Supervisor")
                                        <a class="dropdown-item" href="{{ url('/add-stock') }}">
                                            Add Stock
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/add-new-item') }}">
                                            Add New Item
                                        </a>

                                        <a class="dropdown-item" href="{{ url('/system-alerts') }}">
                                            <small id="alert-count" style="color: red !important;">1</small> Alert(s)
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/get-stock') }}">
                                            Check Inventory
                                        </a>
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->access_level === "Sales Person")
                                        <a class="dropdown-item" href="{{ url('/check-out') }}">
                                            Check Out
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script>
        function checkAlertsCount() {
            $.ajax({
                type: "GET",
                url: "{{ url('/count-new-alerts') }}",

                success:function (returnedCount) {
                    document.getElementById("alert-count").innerHTML = returnedCount;
                }
            })
        }

        function checkLowStockCount() {
            $.ajax({
                type: "GET",
                url: "{{ url('/check-low-stock-count') }}",

                success:function (returnedCount) {
//                    document.getElementById("alert-count").innerHTML = returnedCount;
                }
            })
        }

        function showOverlay(overlayId){
            document.getElementById(overlayId).style.display = "flex";
        }

        function closeOverlay(overlayId){
            document.getElementById(overlayId).style.display = "none";
        }

        $(document).ready(function(){
            setInterval(function () {
                checkAlertsCount();
                checkLowStockCount();
            }, 1500)
        });
    </script>
</body>
</html>
