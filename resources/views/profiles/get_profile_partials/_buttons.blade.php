

<div>
    @if($profile->user->status->id == 2)
        <button class="btn btn-warning btn-block" disabled> 
    @elseif($profile->user->status->id == 3)
        <button class="btn btn-success btn-block" disabled> 
    @else
        <button class="btn btn-danger btn-block" disabled> 
    @endif

    @if($profile->user->id == auth()->user()->id)
        Status: {{ $profile->user->status->status }}

    @else
        {{ $profile->user->name }} status: {{ $profile->user->status->status }}
    @endif
    </button>
</div>
            
   

{{-- Do not display in the page of the logged user or when an admin visit the page --}}

@if(isset($profile) && isset(auth()->user()->profile->id))   

    @if( auth()->user()->profile->id != $profile->id || auth()->user()->role->id < 3 )
        <div class="mt-5 mb-2 text-center">
            <h5>What is next?</h5>
        </div>
    
    <div class="mt-2">
        {{-- Check for flagging --}}
        @if(!is_null($flagged))

        <form action="{{ route('unflag') }}" method="POST">
            <input type="hidden" name="current_user_id" value="{{$profile->id}}">
            @csrf 
            {{ method_field('DELETE') }}
            <button class="btn btn-warning text-white btn-block" type="submit"> 
                <img class="button-icon" src="{{ asset('svg/icons8-flag-filled-96.png') }}" />   Unflag </button>
        </form>


        @else
            <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#report-modal"> 
                    <img class="button-icon" src="{{ asset('svg/icons8-flag-2-96.png') }}" />   Flag 
            </button>
        @endif
    </div>



    <div class="mt-2">
        {{-- Check if auth already matched --}}
        @if(is_null($auth_matched))
            <form action="{{ route('match') }}" method="POST">
                <input type="hidden" name="current_user" value="{{$profile->id}}">
                @csrf
                <button class="btn btn-success btn-block" type="submit"> 
                        <img class="button-icon" src="{{ asset('svg/icons8-heart-outline-96.png') }}" />       
                    Match</button>
            </form>
        @else
        {{-- If already matched give option to unmatch --}}
            <form action="{{ route('unmatch') }}" method="POST">
                <input type="hidden" name="current_user" value="{{$profile->id}}">
                @csrf 
                {{ method_field('DELETE') }}
                <button class="btn btn-warning text-white btn-block" type="submit"> 

                        <img class="button-icon" src="{{ asset('svg/icons8-dislike-96.png') }}" />  
                    
                    Unmatch </button>
            </form>
            
        @endif
    </div>

    <div class="mt-2">

        {{-- Show if the visited user has matched --}}
        @if(is_null($current_matched))
            @if(!is_null($auth_matched))
                <button class="btn btn-light btn-block text-center" disabled> 
                    Waiting for the user to match back
                </button>
            </div>
            @endif
        
        @else



        <div class="mt-5">
            <button class="btn btn-success btn-block" disabled> 
                    <img class="button-icon" src="{{ asset('svg/icons8-heart-outline-96.png') }}" />    
                {{ $profile->user->name }} has matched with 
            </button>

        @endif
    

    {{-- <div class="mt-2"> --}}
        @if(!is_null($current_matched) && !is_null($auth_matched))
            <a class="btn btn-success btn-block mt-3" href="{{ route('messages', [auth()->user()->profile->id, $profile->id]) }}"> 
                Send message
            </a>
        @endif
    </div>

    @endif
@endif      