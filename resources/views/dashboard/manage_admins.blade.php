@extends('dashboard.dashboard_base')

@section('dashboard_content') 
    

    

    <h2>Section title</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
        <thead>
            <tr>            
            <th>id</th>
            <th>Name</th>            
            <th>E-mail</th>
            <th>Role</th>   
            <th></th>
                     
            </tr>
        </thead>
            <tbody>
                @if(isset($users))
                    @foreach($users as $user)
                    <tr>
                    <td> {{ $user->id }} </td>
                    <td> {{ $user->name }}</td>                
                    <td> {{ $user->email }} </td>                 
                    <td>@if($user->role_id == 1) Super admin @else Operator @endif</td>
                    <td>
                        <a class="btn btn-danger" href="#" 
                        onClick="document.getElementById('delete-admin{{ $user['id'] }}').submit();" title="Click to delete">Remove</a>
                        <form action="{{ route('admin_delete_user', $user['id']) }}" method="POST" id="delete-admin{{ $user['id'] }}">
                            @csrf
                            {{ method_field('DELETE') }}
                        </form>    
                    </td>
                </tr>                    
                    @endforeach
                @endif
                
            </tbody>
        </table>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
    
                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{ route('register_admin') }}" aria-label="{{ __('Register') }}">
                            @csrf
    
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
    
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
    
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                            
                            
                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>
                                <div class="col-md-6">
                                    <select  class="form-control"  name="role" required>
                                        <option></option>
                                        <option value="1">Super user</option>
                                        <option value="2">Operator</option>                                    
                                    </select>
                                    @if ($errors->has('role'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button  class="btn btn-primary" type="submit">
                                        Register
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


