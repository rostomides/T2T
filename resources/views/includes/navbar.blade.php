<nav class="navbar navbar-expand-md navbar-default text-light">
    <div class="container">
        <a class="navbar-brand text-white font-weight-bold" href="{{ url('/') }}">
            Tayeboon2Tayebat
        </a>

        
       
        {{-- User hamburger --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#user-menu" aria-controls="user-menu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                {{-- <span class="navbar-toggler-icon"></span> --}}

                <img src="{{ asset('svg/icons8-customer-96.png') }}" alt="" >
            </button>


        @if(Auth::check())
            {{-- matching hamburger --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#user-matching" aria-controls="user-matching" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    
                <img src="{{ asset('svg/icons8-chat-96.png') }}" alt="Matching icone">            

                    @if(((isset($n_unseen_matched_me) ? sizeof($n_unseen_matched_me):0) + (isset($n_unseen_both_matched) ? sizeof($n_unseen_both_matched):0) + (isset($users_unread_messages) ? sizeof($users_unread_messages):0)) > 0)
                        <span class="badge badge-success">
                        {{((isset($n_unseen_matched_me) ? sizeof($n_unseen_matched_me):0) + (isset($n_unseen_both_matched) ? sizeof($n_unseen_both_matched):0) + (isset($users_unread_messages) ? sizeof($users_unread_messages):0))  
                            }} </span>
                    @endif 
                
            </button>
        @endif


        {{-- matching Menu --}}
        <div class="collapse navbar-collapse" id="user-matching">                        
                <ul class="navbar-nav ml-auto">
                    @if(Auth::check())
                        {{-- Only active users can search --}}
                        
                        @if(auth()->user()->role_id == 3)

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('all_active_users') }}">Search</a>
                        </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="matching-dropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Matching  
                                
                                @if(isset($n_unseen_matched_me) && isset($n_unseen_both_matched))
                                @if( sizeof($n_unseen_matched_me)>0 || sizeof($n_unseen_both_matched)>0)
                                    <span class="badge badge-success">{{ sizeof($n_unseen_matched_me) + sizeof($n_unseen_both_matched) }} </span>   
                                @endif                     
                            
                            @elseif(isset($n_unseen_matched_me) && sizeof($n_unseen_matched_me)>0)
                                <span class="badge badge-success">{{ sizeof($n_unseen_matched_me) }}</span>
                            @elseif(isset($n_unseen_both_matched) && sizeof($n_unseen_both_matched)>0)
                                <span class="badge badge-success">{{ sizeof($n_unseen_both_matched) }}</span>
                            @endif
                            
                            <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right bg-info" aria-labelledby="matching-dropdown">
                            
                                <a class="dropdown-item text-white" href="{{ route('my_matches') }}">I matched with</a>
                            
                                <a class="dropdown-item text-white" href="{{ route('matched_me') }}">Matched with me 
                                    @if(isset($n_unseen_matched_me) && sizeof($n_unseen_matched_me)>0)
                                        <span class="badge badge-success">{{ sizeof($n_unseen_matched_me) }}</span>
                                    @endif
                                </a>
                            
                                <a class="dropdown-item text-white" href="{{ route('both_match') }}">Both matched
                                    @if(isset($n_unseen_both_matched) && sizeof($n_unseen_both_matched)>0)
                                        <span class="badge badge-success">{{ sizeof($n_unseen_both_matched) }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item text-white">
                                <a class="nav-link text-white" href="{{ route('my_discussions') }}">My discussions
                                    @if(isset($users_unread_messages) && sizeof($users_unread_messages)>0)
                                        <span class="badge badge-success">{{ sizeof($users_unread_messages) }}</span>
                                    @endif                                   
                                
                                </a>
                            </li>
                        </ul>
                            @elseif(auth()->user()->role_id < 3)
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item text-white">
                                <a class="nav-link text-white" href="{{ route('admin_get_profile', $profil_id) }}"> See {{ $profil_name }} profile
                                    </a>
                                </li>

                                <li class="nav-item text-white">
                                    <a class="nav-link text-white" href="{{ route('admin_users_discussions', $profil_id) }}"> See {{ $profil_name }} discussions   
                                    </a>
                                </li>    
                            @endif 
                        @endif
                </ul>
            </div>


        {{-- User Menu --}}

        <div class="collapse navbar-collapse" id="user-menu">                   
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
                    <li class="nav-item dropdown">
                        <a id="user-dropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right bg-info" aria-labelledby="user-dropdown">

                            @if(auth()->user()->role_id < 3)
                                <a class="dropdown-item text-white" href="{{ route('change_password') }}"> Password reset</a>
                                <a class="dropdown-item text-white" href="{{ route('dashboard') }}"> Dashboard</a>                                        

                            @else
                                @if(isset(auth()->user()->profile)) 
                                    <a class="dropdown-item text-white" href="{{ route('my_profile') }}">My profile</a>
                                    <a class="dropdown-item text-white" href="{{ route('edit_profile') }}">Edit my profile</a>
                                    <a class="dropdown-item text-white" href="{{ route('change_password') }}"> Password reset</a>
                                @endif
                                
                            @endif
                            

                            <a class="dropdown-item text-white" href="{{ route('logout') }}"
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