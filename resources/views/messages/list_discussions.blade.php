@extends('layouts.app')

@section('content')




<div class="container">
<div class="row mt-5">
    @if(sizeof($profiles)==0)
        <p>You have no archived discassions</p>

    @else 
    @foreach($profiles as $profile)  
        <div class="col-md-4 mt-2">
            <div class="card h-100">
                <img class="card-img-top"
                
                {{-- src="{{ route('picture', [$profile->id,$profile->picture]) }}"   --}}

                @if(auth()->user()->role_id < 3)
                    src="{{ route('admin_pictures', [$profile->id,$profile->picture]) }}"
                @elseif($profile->id == auth()->user()->profile->id)
                    src="{{ route('picture', [$profile->id,$profile->picture]) }}"
                @else
                    src="{{ route('picture', [$profile->id,$profile->picture]) }}"
                @endif
                
                
                alt="Card image cap" style="height:200px !important;">
                <div class="card-body">
                    <div class="container">
                        
                        <p class="card-title">{{$profile->name}}</p>
                        
                        <p class="card-text">{{Carbon\Carbon::parse($profile->birthday)->diffInYears(Carbon\Carbon::now())}} years old</p>
                           
                    </div>
                                        
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-sm-6">
                                @if(auth()->user()->role_id < 3)
                                    <a href="{{ route('admin_user_messages', [$profil_id, $profile->id])}}" class="btn btn-primary">See discussion</a>
            
                                @elseif(auth()->user()->role_id == 3 && $profile->id != auth()->user()->profile->id)
                                    <a href="{{ route('messages', [auth()->user()->profile->id, $profile->id])}}" class="btn btn-primary">See discussion</a>
                                @endif  
                            </div> 
                            <div class="col-sm-6">
                                @if(isset($users_unread_messages))
                                    @if(in_array($profile->id, $users_unread_messages) )
                                       <a href="#" class="btn-sm btn-success" disabled>
                                          New
                                       </a>
                                    @endif   
                                @endif  
                                
                            </div> 
                        </div> 
                    </div>        

                </div>
            </div>
        </div>
    @endforeach
</div>

   

    @endif

</div>

   




@endsection

@section("css")
<style>
    /* body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
} */
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}





</style>



@endsection