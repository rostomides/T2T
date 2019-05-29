@extends('dashboard.dashboard_base')

@section('dashboard_content') 
    

    

    <h2>Users waiting for interviews</h2>
    <div >
        <table>
        <thead>
            <tr>            
            <th>id</th>
            <th>Name</th>
            <th>Phone number</th>
            <th>email</th>
            <th>Registration date</th>
            <th>status</th>
            </tr>
        </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                <td> <a href="{{ route('admin_get_profile', $user->profile->id) }}">{{ $user->profile->id }}</a> </td>
                <td> <a href="{{ route('admin_get_profile', $user->profile->id) }}">{{ $user->name }} </a></td>
                <td> {{ $user->profile->phone }} </td>
                <td> {{ $user->email }} </td>
                <td> {{Carbon\Carbon::parse($user->profile->created_at)->format('Y-m-d')}} 
                <td> {{ $user->status->status }}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>

@endsection


