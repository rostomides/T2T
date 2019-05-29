@extends('layouts.app1')

@section('content')




<div class="container">
        {{-- Include the messages --}}
        @include("includes.messages")

        <div class="align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard: Current user {{ auth()->user()->name }}</h1>                    
        </div>

        <div class="row">        
            <div class="col-md-3 mb-5">
                {{-- Include the messages --}}
                @include("dashboard.partials._left_side_bar")  
            </div>

    
            <div class="col-md-9" style="overflow-y:scroll !important; overflow-x:scroll !important;max-height:600px !important; max-width: 100% !important;">
                    @yield("dashboard_content")
            </div>

            
        </div>
</div>
@endsection



@section("css")

<style>
body {
    font-size: 16px;
}

#sidebar .nav-link {
    color: white !important;
}
table{
    min-width:100% !important;    
    overflow:auto !important;
    font-size: 0.9rem !important;
}
td, th{
    text-align:center !important;
    min-width:80px !important;
    max-width:400px !important;
    height: 80px !important;
    overflow-x:auto !important;
    border-bottom: 1px solid grey;
}
.form-control{
    font-size: 0.6rem !important;
}
.btn{
    font-size: 0.6rem !important;
}
.form-table{
    min-width:150px !important;
    vertical-align: auto !important;
    padding-top:20px !important;
}



</style>



@endsection