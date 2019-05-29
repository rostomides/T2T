<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tayeboon2Tayebat</title>

    

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-info navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Tayeboon2Tayebat
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else

                            {{-- Only active users can search --}}
                            @if(auth()->user()->role_id == 3)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('all_active_users') }}">Search</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('my_matches') }}">I matched with</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('matched_me') }}">Matched with me 
                                        @if(isset($n_unseen_matched_me) && sizeof($n_unseen_matched_me)>0)
                                            <span class="badge badge-danger">{{ sizeof($n_unseen_matched_me) }}</span>
                                        @endif
                                    </a>
                                </li>

                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('both_match') }}">Both matched
                                        @if(isset($n_unseen_both_matched) && sizeof($n_unseen_both_matched)>0)
                                            <span class="badge badge-danger">{{ sizeof($n_unseen_both_matched) }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('my_discussions') }}">My discussions
                                        @if(isset($users_unread_messages) && sizeof($users_unread_messages)>0)
                                            <span class="badge badge-danger">{{ sizeof($users_unread_messages) }}</span>
                                        @endif                                    
                                    
                                    </a>
                                </li>
                            
                            @elseif(auth()->user()->role_id < 3)
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin_get_profile', $profil_id) }}"> See {{ $profil_name }} profile
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_users_discussions', $profil_id) }}"> See {{ $profil_name }} discussions   
                                    </a>
                                </li>

                            @endif  


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    @if(auth()->user()->role_id < 3)
                                        <a class="dropdown-item" href="{{ route('change_password') }}"> Password reset</a>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}"> Dashboard</a>                                        

                                    @else
                                       @if(isset(auth()->user()->profile)) 
                                            <a class="dropdown-item" href="{{ route('my_profile') }}">My profil</a>
                                            <a class="dropdown-item" href="{{ route('edit_profile') }}">Edit my profile</a>
                                            <a class="dropdown-item" href="{{ route('change_password') }}"> Password reset</a>
                                        @endif
                                        
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
            <div id="messages" class="container">
                @include("includes.messages")
            </div>  


            @yield('content')

        </main>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield("javascript")


</body>
</html>
