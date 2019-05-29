<div class="row">
    @foreach($profile->pictures as $pict)

    <div class="col-md-6 text-center p-2">

            @if(auth()->user()->role_id < 3)
                <img  src="{{ route('admin_pictures', [$profile->id,$pict->picture]) }}" alt="" class="img-fluid" />

            @elseif(auth()->user()->profile->id == $profile->id)
                <div>
                    <img   src="{{ route('my_pictures', [$profile->id,$pict->picture]) }}" alt="" class="img-fluid"/>
                </div>

                <div class="row container">
                    @if($pict->is_main)
                        <p>Main picture</p>
                    @else
                    <div>
                        <form action="{{ route('change_to_main_picture') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $pict->id }}" name="picture">
                            <button class="btn btn-info" type="submit" title="Make as main picture"> <img src="{{ asset('svg/icons8-name-96.png') }}" class="button-icon"> </button>
                        </form>
                    </div>
                        
                    <div>
                        <form action="{{ route('delete_picture') }}" method="POST">
                            <input type="hidden" value="{{ $pict->id }}" name="picture">
                            @csrf 
                            {{ method_field('DELETE') }}
                            
                            <button class="btn btn-danger" type="submit" title="Delete picture"> <img src="{{ asset('svg/icons8-trash-can-96.png') }}" class="button-icon" > </button>
                        </form>
                    </div>
                        
                    @endif
                </div>
            @else
            <div>
                <img   src="{{ route('picture', [$profile->id,$pict->picture]) }}" alt="" class="img-fluid"/>
            </div>
            @endif

    </div>

    @endforeach
</div>


@if(auth()->user()->role_id == 3)
    @if(auth()->user()->profile->id == $profile->id)
    <div class="row">
        
        <form method="POST" action="{{ route('add_picture') }}" enctype="multipart/form-data">
            @csrf  
            {{-- Picture  --}}
            <div class="form-group">
                <label for="picture">Please select additional pictures to upload (you can upload up to 5 pictures) *</label>
                <input type="file" class="form-control" name="picture">
                <span>
                <small>* Please provide pictures without sunglasses (maximum size: 2mb) </small>
                </span>
            </div>

            <input type="submit" class="btn btn-success">
        </form>

        
        
    </div>
    @endif
@endif
