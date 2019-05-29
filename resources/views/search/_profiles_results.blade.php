
<div class="row">    
    @if(!is_null($profiles))
   
    <div class="container col-sm-6 col-sm-6">
        @if(\Route::getCurrentRoute()->getName() == "all_active_users" || isset($sorting))

            <form method="GET" action="{{ route('sort_users') }}">
                @csrf
                
                <div class="form-row">
                    
                    <div class="form-group col-10">                        
                        <select id="sort_search" name="sort_search" class="form-control" pla>                    
                            <option value="" disabled selected> Sort profiles By</option>
                            <option value="age">Age</option>
                            <option value="nameAZ">Name A-Z</option>
                            <option value="nameZA">Name Z-A</option>
                            <option value="first">Registration date ascending</option>
                            <option value="last">Registration date descending</option>                         
                        </select>
                    </div> 
                    <div class="form-group col-2">                       
                        <button class="btn btn-info d-block" type="submit">Sort</button>
                    </div>                
                </div>
            </form>
        </div>
        <div class="container col-sm-6">
            <form method="GET" action="{{ route('search_user_by_name') }}">
                @csrf
                
                <div class="form-row">
                    <div class="form-group col-sm-4"> 
                        {{-- <label for="search_type">Search type</label> --}}
                        <select  name="search_type" class="form-control">
                            <option value="startswith">Username starts with</option>
                            <option value="contains">Username contains</option>                            
                        </select>
                    </div>
                    

                    <div class="form-group col-sm-7"> 
                        {{-- <label for="username_search">Keyword in username</label> --}}
                        <input type="text" class="form-control" name="username_search" placeholder="Keyword in the username">
                    </div>               

                    <div class="form-group col-sm-1">
                        <button class="btn btn-info d-block" type="submit">Search</button>  
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="row container">    
        @elseif(\Route::getCurrentRoute()->getName() == "my_matches")
            
                <h2>You have matched with {{ sizeof($profiles) }} @if(sizeof($profiles)>1 ) persons. @else person. @endif</h2>
            
            
        @elseif(\Route::getCurrentRoute()->getName() == "matched_me")
            <h2> {{ sizeof($profiles) }} @if(sizeof($profiles)>1 ) persons have @else person has @endif matched with you.</h2>
        
        @elseif(\Route::getCurrentRoute()->getName() == "matched_me")
            <h2> {{ sizeof($profiles) }} @if(sizeof($profiles)>1 ) have persons @else has person @endif matched with you.</h2>

        @endif
    </div>
</div>
    
    <div class="row mt-4">
        @foreach($profiles as $profile)  
            <div class="col-sm-6 col-md-4  mt-2 mx-0">
                <div class="card h-100">

                    {{-- Modify this --}}
                    <img class="card-img-top" src="{{ route('picture', [$profile->id, $profile->picture] ) }}"  
                    
                    alt="Card image cap" style="height:200px !important;">
                    {{-- Modify this --}}



                    <div class="card-body">
                        <h5 class="card-title">{{$profile->name}}</h5>
                        <p class="card-text">{{Carbon\Carbon::parse($profile->birthday)->diffInYears(Carbon\Carbon::now())}} years old</p>
                        {{-- <p class="card-text">@if($profile->sex_id == 1) Male @else Female @endif</p> --}}
                        <p class="card-text text-truncate">{{ $profile->location }}</p>
                        
                        <div class="row px-0">
                            <div class="col-sm-12 col-md-6">
                                <a href="{{ route('get_profile', $profile->id)}}" class="btn btn-primary">Visit profile</a>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                @if(isset($action))
                                    @if($action == 'unmatch')
                                        <form action="{{ route('unmatch') }}" method="POST">
                                            <input type="hidden" name="current_user" value="{{$profile->id}}">
                                            @csrf 
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-warning text-white" type="submit"> 
                                                    
                                                Unmatch </button>
                                        </form>
        
                                    @elseif($action == 'match')
                                        <form action="{{ route('match') }}" method="POST">
                                            <input type="hidden" name="current_user" value="{{$profile->id}}">
                                            @csrf
                                            <button class="btn btn-success" type="submit"> 
                                                   
                                                    Match</button>
                                        </form>
                                    @endif
                                @endif
                                    
                            </div>
                        </div>
                        



                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-5">
        @if(\Route::getCurrentRoute()->getName() == "all_active_users")
            {{$profiles->links()}}
        @endif
    </div>


    </div>
    @else
        <div class="container text-center">
            <p class="h1 text-center text-warning">There are no profiles available.</p> 
            <div class="mt-5">
                <a class="btn btn-info" href="{{ route('all_active_users') }}"> Back to search</a>

                <a class="btn btn-info" href="{{ route('my_profile') }}"> Back to profile</a>

            </div>
             
        </div> 

    @endif