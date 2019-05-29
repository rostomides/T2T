@extends('dashboard.dashboard_base')

@section('dashboard_content') 

<h2>Flagged users</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
        <thead>
            <tr>
            <th>Reported</th>
            <th>Reported by</th>
            <th>When</th>
            <th>Reason</th>
            <th>See discussions</th> 
            <th>Take action</th>
            </tr>
        </thead>
            <tbody>
                @foreach($flags as $flag)
                <tr>                
                <td> <a href="{{ route('admin_get_profile', $flag->flagged) }}">
                    {{ \App\User::find($flag->flagged)->name }} </a>
                    <br> 
                    
                    @if(\App\Flag::where("flagged", $flag->flagged)->where('admin_check', 1)->count() == 0)
                        Never flagged before
                    @else
                        Flagged {{ \App\Flag::where("flagged", $flag->flagged)->where('admin_check', 1)->count() }} times
                    @endif
                    
                </td>
                <td> 
                    <a href="{{ route('admin_get_profile', $flag->flagging) }}">
                        {{ \App\User::find($flag->flagging)->name }} </a>
                </td>
                <td> 
                    {{ date('Y-m-d', strtotime($flag->created_at)) }}
                </td>
                <td> 
                    {{ $flag->description }}
                </td>
                <td> 
                    <a href="{{ route('admin_user_messages',[$flag->flagged, $flag->flagging]) }}">See</a>
                </td>


                
                <td class="form-table"> 
                    
                        <form action="{{ route('admin_flagged_action') }}" method="POST">
                            @csrf
                            <input type="hidden" name="flag_id" value="{{ $flag->id }}">
                            <input type="hidden" name="flagged_user_id" value="{{ $flag->flagged }}">
                            <div class="form-row"> 
                                <div class="form-group col-md-8">
                                    <select name="action" class="form-control">
                                        <option selected></option>
                                        <option value="1">Ignore flag</option>
                                        @if($page == 0)
                                            <option value="2">Confirm flag</option>
                                            <option value="3">Confirm flag and ban</option>
                                        @endif
                                    </select>
                                </div>
                        
                                <div class="form-group col-md-4">
                                    <input type="submit" value="Execute" class="form-control btn btn-warning btn-sm">
                                </div> 
                            </div>                        
                        </form>                    
                </td>

                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>




@endsection