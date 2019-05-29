<div class="row">
<div class="text-center font-weight-bold">
    <p>By deleting your account you lose ALL the information you entred in tayeboon2tayebat website since the creation of your account without any possibility of recovery.</p>
</div>

</div>

<div class="row">
    <div class="container">
        <form action="{{ route('remove_my_account') }}" method="POST">        
            <input type="hidden" value="{{ auth()->user()->profile->id }}" name="logged_user">
            <label for="picture">Please enter your password (for authentification reasons) </label> 
            <input type="password" class="form-control col-4 mb-3" name="password" required>
            @csrf 
            <button class="btn btn-danger d-block" type="submit"> Delete my account definitively </button>
        </form>

    </div>
    
</div>                
                   





