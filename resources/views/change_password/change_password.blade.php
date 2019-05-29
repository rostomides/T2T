
@extends(auth()->user()->role_id < 3 ? 'dashboard.dashboard_base' : 'layouts.app')
@section(auth()->user()->role_id < 3 ? 'dashboard_content' : 'content')




<div class="container">
    <div class="text-center mb-3"><h1>Password reset</h1></div>
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change password for the user ({{ auth()->user()->name}})</div>
                <div class="card-body">
                    <form id="register-form" method="POST" action="{{ route('store_new_password') }}" >
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $name }}" required autofocus>                                
                            </div>
                        </div>  

                        <div class="form-group row">
                            <label for="current password" class="col-md-4 col-form-label text-md-right">Enter your current password</label>
                            <div class="col-md-6">
                                <input id="current_password" type="text" class="form-control" name="current_password" value="{{ old('current_password') }}" required>                                
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Enter the new password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Enter the new password again</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="btn-register" class="btn btn-primary" type="submit">
                                    Change my password
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>



@endsection