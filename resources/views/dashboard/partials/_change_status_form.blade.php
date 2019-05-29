<form action="{{ route('Change_user_status') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <div class="form-row"> 
        <div class="form-group col-md-8">
            <select name="status" class="form-control">
                @foreach($statuses as $status)                                
                    @if($status->id == $user->status_id)
                        <option value="{{ $status->id }}" selected> {{ $status->status }}</option>
                    @else
                        <option value="{{ $status->id }}"> {{ $status->status }} </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <input type="submit" value="OK" class="form-control btn btn-warning btn-sm">
        </div> 
    </div>

</form>