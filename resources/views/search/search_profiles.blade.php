@extends('layouts.app')

@section('content')




<div class="container mt-5">



    @if(\Route::getCurrentRoute()->getName() == "all_active_users" || isset($sorting))
    <div class="row">
        <div class="container">            

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="advanced-search">
                        <h5 class="mb-0">
                            <button class="btn btn-info btn-block" data-toggle="collapse" data-target="#collapse-search" aria-expanded="true" aria-controls="collapse-search">
                                Advanced search
                            </button>
                        </h5>
                    </div>
                
                    <div id="collapse-search" class="collapse" aria-labelledby="advanced-search" data-parent="#accordion">
                    <div class="card-body">

                            @include("search._search_bar")

                    </div>
                    </div>
                </div>
            </div>   

        </div>
    </div>
    @endif
       


    <div class="container mt-5">
        @include("search._profiles_results")
        
    </div>

    
    
    

    

</div>

   




@endsection







