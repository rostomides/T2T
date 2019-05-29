<form method="GET" class="form-horizontal" action={{ route("search_profiles") }} >         
       
    {{-- @csrf --}}
        {{-- age --}}
        <div class="form-row">
            <div class="form-group col-sm-4">
            <label for="min-age">Minimum age</label>       
                <select name="min-age" class="form-control">
                    <option selected></option>
                    @foreach(range(18, 80) as $age)
                        <option value="{{ $age }}"> {{ $age }} </option> 
                    @endforeach                                                                           
                </select>
            </div>

            <div class="form-group col-sm-4">
            <label for="max-age">Maximum age</label>       
                <select name="max-age" class="form-control">
                    <option selected></option>
                    @foreach(range(18, 80) as $age)
                        <option value="{{ $age }}">{{ $age }}</option> 
                    @endforeach                                                                           
                </select>
            </div>
            {{-- Ethnicity --}}
            <div class="form-group col-sm-4">
                <label for="ethnicity">Ethnicity</label>
                <select name="ethnicity" class="form-control">
                    <option selected></option>
                    @foreach($ethnicities as $ethnic)
                        <option value="{{ $ethnic['id'] }}">{{ $ethnic['ethnicity'] }}</option> 
                    @endforeach                                                                           
                </select>
            </div>
        </div>

        <div class="form-row"> 
             {{-- Languages --}}
            <div class="form-group col-sm-4">
                <label for="language">Language</label>          
                <select class="form-control" name='languages' id='language'>
                    <option selected></option>
                    @foreach($languages as $language)
                        <option value="{{  $language['id'] }}">{{  $language['language'] }}</option>
                    @endforeach
                </select>                                    
            </div>  

             {{-- Country grew up --}}
            <div class="form-group col-sm-4">
                <label for="country_grew_up">Grew up in</label>
                <select name="country_grew_up" class="form-control">
                    <option selected></option>
                    @foreach($grew_ups as $gup)
                        <option value="{{ $gup['id'] }}">{{ $gup['country_grew_up'] }}</option> 
                    @endforeach                                                                           
                </select>
            </div>

             {{-- Location --}}
            <div class="form-group col-sm-4">
                <label for="location">Location in Canada</label>
                <select name="location" class="form-control">
                    <option selected></option>
                    @foreach($locations as $location)                                        
                        <option value="{{ $location["id"] }}">{{ $location["location"] }}</option>
                    @endforeach
    
                </select>
            </div>
        </div>


        <div class="form-row">
            {{-- Status in canada --}}
            <div class="form-group col-sm-4">
                <label for="status_in_canada">Status in Canada</label>
                <select name="status_in_canada" class="form-control">
                    <option selected></option>
                    @foreach($status_in_canada as $stcanada)                                        
                        <option value="{{ $stcanada["id"] }}">{{ $stcanada["status_in_canada"] }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Marital Status --}}
            <div class="form-group col-sm-4">
                <label for="marital_status">Marital status</label>
                <select name="marital_status" class="form-control">
                    <option selected></option>
                    @foreach($marital_status as $ms)                                        
                        <option value="{{ $ms["id"] }}">{{ $ms["marital_status"] }}</option>
                    @endforeach
    
                </select>
            </div>

            {{-- has children --}}
            <div class="form-group col-sm-4">
                <label for="haschildren">Has Children</label>
                <select id ="haschildren" name="haschildren" class="form-control">
                    <option selected></option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>                                    
                </select>
            </div>


        </div>
        


        <div class="form-row">
            {{-- relocate --}}
            <div class="form-group col-sm-6">
                <label for="relocate">Willing to relocate</label>
                <select name="relocate" class="form-control">
                    <option selected></option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>                                    
                </select>
            </div>

            {{-- Education --}}
            <div class="form-group col-sm-6">
                <label for="education">Highest eduction level</label>
                <select name="education" class="form-control">
                    <option selected></option>
                    @foreach($educations as $educ)
                    <option value="{{ $educ['id'] }}">{{ $educ['education'] }}</option>   
    
                    @endforeach                                                 
                </select>
            </div>

        </div>

         


       


        


         {{-- Status in canada --}}
        {{-- <div class="form-group col-md-12">
            <label for="status_in_canada">Status in Canada</label>
            <select name="status_in_canada" class="form-control">
                <option selected></option>
                
                @foreach($status_in_canada as $stcanada)                                        
                    <option value="{{ $stcanada["statusincanada_id"] }}">
                        {{ $stcanada["status_in_canada"] }}

                        ( <span>{{ $stcanada['count_statusincanada'] }} 
                                @if($stcanada['count_statusincanada'] == 1 ) user @else users @endif </span>)
                    
                    </option>
                @endforeach
            </select>
        </div>  --}}



       

        {{-- <div class="form-group col-md-12">
            <label for="location">Location in Canada</label>
            <select name="location" class="form-control">
                <option selected></option>
                @foreach($locations as $location)                             
                     <option value="{{ $location["location_id"] }}">
                        {{ $location["location"] }}
                        
                            ( <span>{{ $location['count_locations'] }} 
                                    @if($location['count_locations'] == 1 ) user @else users @endif </span>)
                    </option> 
                @endforeach 

            </select>
        </div> --}}



        

        {{-- Marital Status --}}
        {{-- <div class="form-group col-md-12">
            <label for="marital_status">Marital status</label>
            <select name="marital_status" class="form-control">
                <option selected></option>
                @foreach($marital_status as $ms)                                        
                    <option value="{{ $ms["maritalstatus_id"] }}">
                        {{ $ms['marital_status'] }}
                        ( <span>{{ $ms['count_maritalstatus'] }}
                        @if($ms['count_maritalstatus'] == 1 ) user @else users @endif </span>)
                    </option>
                @endforeach

            </select>
        </div> --}}





                         

        

              
        


        
        
        <button type="submit" class="btn btn-info btn-block">Search </button>
        
        
</form>