@extends('layouts.app')

@section('content')




<div class="container">
        
        <div class="container">    
            <div class="row">

                <div class="container col-md-4 text-sm-center text-md-left mt-4">
                                    
                        <img class="img-thumbnail img-fluid"  
                            @if(auth()->user()->role_id < 3)
                                src="{{ route('admin_pictures', [$profile->id,$main_pict]) }}"
                            @elseif($profile->id == auth()->user()->profile->id)
                                src="{{ route('my_pictures', [$profile->id,$picture]) }}" 
                            @else
                                src="{{ route('picture', [$profile->id,$picture]) }}"
                            @endif
                        alt=""/>
                        
                    
                </div>


                <div class="col-md-4 mt-4 text-sm-center text-md-left">
                    
                    <h1 class="text-capitalize mt-4">
                        {{$profile->user->name}}
                    </h1>
                    <h4 class="mt-4">
                        {{Carbon\Carbon::parse($profile->birthday)->diffInYears(Carbon\Carbon::now())}} years old
                    </h4>

                    <div class="mt-4">                                
                        <img src="{{ asset('svg/icons8-home-filled-100.png') }}"  class="footer-icon d-inline">   
                        <h4 class="ml-2 d-inline align-middle">
                            {{$profile->location->location}}
                        </h4>  
                    </div>
                    
                    <div class="mt-4 text-sm-center text-md-left ">
                        <img src="{{ asset('svg/icons8-business-filled-100.png') }}"  class="footer-icon d-inline">     
                        <h4 class="ml-2 d-inline align-middle">
                            {{$profile->profession->profession}}
                        </h4>

                    </div>
                    
                </div>
                <div class="col-md-4 text-sm-center text-md-left mt-4">
                        @include('profiles.get_profile_partials._buttons')

                </div>
            </div>

            <div class="row mt-5">


                <div class="container col-md-4 text-sm-center text-md-left mb-4">

                        @include('profiles.get_profile_partials._about')

                </div>





                <div class="col-md-8">

                    {{-- first row ends here  --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">I am</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">I am looking for</a>
                        </li>
                        @if(isset($payments) && isset($expiration))
                            <li class="nav-item">
                                <a class="nav-link" id="account_info-tab" data-toggle="tab" href="#account_info" role="tab" aria-controls="account_info" aria-selected="false">My account information</a>
                            </li>
                        @endif

                        @if(auth()->user()->role_id>2)
                            @if(auth()->user()->id == $profile->user->id)
                                <li class="nav-item">
                                    <a class="nav-link" id="manage-tab" data-toggle="tab" href="#manage" role="tab" aria-controls="manage" aria-selected="false">Manage my account</a>
                                </li>
                            @endif
                        @endif
    
                        <li class="nav-item">
                            <a class="nav-link" id="pictures-tab" data-toggle="tab" href="#pictures" role="tab" aria-controls="pictures" aria-selected="false">Pictures</a>
                        </li>
                        
                    </ul>
    
                
    
                <div class="row mt-5">
                    <div class="tab-content profile-tab pl-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="pl-3 text-justify div-overflow ">   
                                        {{$profile->selfdescription->description}}
                                
                                </div>
                            </div>
                                        
                        </div>
    
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="pl-3 text-justify div-overflow">
                                    {{$profile->lookingfor->what_want}}
                                </div>
                            </div>   
                        </div>   
    
                        
    
    
                        <div class="tab-pane fade" id="account_info" role="tabpanel" aria-labelledby="account_info-tab">
                            <div class="row">
                                <div class="col-md-12 pl-3">
    
                                    @include('profiles.get_profile_partials._account_information')
                                                                    
                                </div>
                            </div>
                        </div>
    
    
    
                        <div class="tab-pane fade" id="pictures" role="tabpanel" aria-labelledby="pictures-tab">
                            
                            @include('profiles.get_profile_partials._pictures')
                                    
                                
                            
                        </div>


                        @if(auth()->user()->role_id>2)
                            @if(auth()->user()->id == $profile->user->id)
                                <div class="tab-pane fade" id="manage" role="tabpanel" aria-labelledby="manage-tab">
                                    
                                    @include('profiles.get_profile_partials._manage_account')
                                
                                </div>
                            @endif
                        @endif
    
    
                    </div>
                </div>


            </div>

            </div>

                

        </div>
        
    </div>  

               
        @include('profiles.get_profile_partials._interview')
    </div>
        
    
</div>

   


<!-- Report Modal -->

@include('profiles.get_profile_partials._report_modal')

<!-- Picture Modal -->

@include('profiles.get_profile_partials._picture_modal')


@endsection

@section("javascript")

<script>
    $( document ).ready(function() {

        $(".img-fluid").click(function(){  
            $('#picture_space').empty();
            $('#picture_space').append(
                '<img   src="' + $(this).attr('src')+"/full" +'" alt="" style="max-width:100%;"/>'
            )
            $('#picture-modal').modal('toggle');
        });

    }) 
  </script>

@endsection