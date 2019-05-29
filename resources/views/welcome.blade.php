<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <style>
        body{
            background-image: url("{{ asset('svg/welcome-bg.jpeg') }}");
            background-repeat: no-repeat;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        </style>
        
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-default text-light">
            <div class="container">
                <a class="navbar-brand text-white font-weight-bold" href="{{ url('/') }}">
                    Tayeboon2Tayebat
                </a>
            
                    @if (Route::has('login'))
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                        @auth
                            @if(auth()->user()->role_id == 3)
                                @if(auth()->user()->status_id == 1)
                                    <a href="{{ route('create_profile') }}" class="nav-link">Home</a>
                                @elseif(auth()->user()->status_id >1)
                                    <a href="{{ route('my_profile') }}" class="nav-link">Home</a>
                                @endif
                            @else
                                <a href="{{ route('dashboard') }}"  class="nav-link">Home</a>                        
                            @endif
                        </li>
                            


                            
                        @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}"  class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}"  class="nav-link">Register</a>
                        </li>
                        @endauth
                    </ul>
                    @endif
            </div>
        </nav>

        <div class="container mt-5">

            <div id="messages" class="container">
                @include("includes.messages")
            </div>                 
            
            <div class="text-center">

                    <div class="jumbotron jumbotron-fluid d-block">
                        <div class="container">
                            <h1 class="display-4">Tayeboon 2 Tayebat</h1>
                            <p class="lead">This is a demo version</p>
                            
                        </div>
                    </div>

            </div>
                
            

            
        </div>


        @include('includes.footer')




        
    </body>
</html>
