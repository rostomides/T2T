@extends('layouts.app')

@section('content')




<div class="container">
    <h4 >Discussion between <a href="{{ route('admin_get_profile', $first_user->id ) }}">{{ $first_user->user->name }}</a> and <a href="{{ route('admin_get_profile', $second_user->id ) }}">{{ $second_user->user->name }}</a></h4>
    <div class="row">
        @if(sizeof($messages)>0)

            @foreach($messages as $message)
                @if($message->user_1 == $first_user->id)
                <div class="col-md-12">
                    @if($first_user->sex_id == 1)
                        <div class="card mb-3">
                    @else
                        <div class="card  mb-3">
                    @endif
                        <div class="card-header">{{ $first_user->user->name }} said...</div>

                        <div class="card-body">                            
                            <p class="card-text">{{ $message->message }}</p>
                        </div>

                        <div class="card-footer text-muted">
                                <p>{{ $message->created_at }}</p>   <p>@if($message->seen) read @else Unread @endif</p>
                        </div>

                    </div>
                </div>
                    
                @else
                <div class="col-md-12">
                    @if($second_user->sex_id == 1)
                        <div class="card  mb-3">
                    @else
                        <div class="card  mb-3">
                    @endif
                        <div class="card-header">{{ $second_user->user->name }} said...</div>
                        <div class="card-body">                            
                            <p class="card-text">{{ $message->message }}</p>
                        </div>
                        <div class="card-footer text-muted">
                                {{ $message->created_at }}  
                        </div>
                    </div>
                </div>

                @endif
            @endforeach

        @else
            <p class="text-white">The discussion hasen't started yet, be the first to send a message</p>
        @endif
    </div>    

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