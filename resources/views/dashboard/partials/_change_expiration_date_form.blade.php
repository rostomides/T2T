<form action="{{ route('Change_expiration_date') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <div class="form-row"> 
        <div class="form-group col-md-8">
            <input type="date" class="form-control" name="expire_date" value="{{ $user->profile->membership_end }}">
        </div>

        <div class="form-group col-md-4">
            <input type="submit" value="OK" class="form-control btn btn-warning btn-sm">
        </div> 
    </div>

</form>