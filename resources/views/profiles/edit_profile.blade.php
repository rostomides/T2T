@extends('layouts.app')

@section('content')




<div class="container">

        {{-- Include the messages --}}
        
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">Welcome {{ auth()->user()->name }} , create or update your profile </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    {{-- Form strats here --}}

                    <form method="POST" action="{{ route('update_profile') }}">
                        @csrf
                        <div class="form-row">  
                            
                            {{-- Phone number 
                            <div class="form-group col-md-12">
                                <label for="phone">What is your phone number? *</label>
                                <input id="phone" type="text" class="form-control" name="phone"  
                                value="{{ $profile->phone }}" required>
                                <span class="">
                                <small>* Please provide numbers or spaces only </small>
                                </span>
                            </div> --}}

                            {{-- Phone number --}}
                            <div class="form-group col-md-12">
                                <label for="phone">What is your phone number? *</label>
                                <div class="form-row">
                                    <div class="col-3 form-group">
                                        <input  type="text" class="form-control phone-number-three phone" id ="phone-first-three" name="phone-first-three"  
                                        value="{{ $profile['phone-first-three'] }}" required placeholder="3 digits">
                                    </div>                                   
                                
                                    <div class="col-3 form-group"> 
                                        <input  type="text" class="form-control phone-number-three phone" name="phone-second-three" id="phone-second-three"  
                                        value="{{ $profile['phone-second-three']  }}" required placeholder="3 digits">                                        
                                    </div>


                                    <div class="col-3 form-group"> 
                                        <input  type="text" class="form-control phone-number-four phone" name="phone-four"  id="phone-four"
                                        value="{{ $profile['phone-last-four'] }}" required placeholder="4 digits">
                                    </div>

                                    <div class="col-3 form-group" id="phone-valid">
                                        
                                    </div>
                                </div>  
                            </div> 

                            <div class="form-group col-md-12">
                                <label for="birthday">What is your date of birth? *</label>
                                <div class="form-row">
                                    <div class="col-3 form-group">
                                        <label for="year">Year *</label>
                                        <select name="year" class="form-control" id="year">
                                            @for($i=1940;$i<=(date("Y")-18);$i++)
                                                @if($i == $profile['year'])
                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                @else
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select> 
                                    </div>
                                    <div class="col-2 form-group">
                                        <label for="month">Month *</label>
                                        <select name="month" class="form-control" id="month">
                                            @for($i=1;$i<=12;$i++)
                                                @if($i == $profile['month'])
                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                @else
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select> 
                                    </div>
                                    <div class="col-2 form-group">
                                        <label for="day">Day *</label>
                                        <select name="day" class="form-control" id="day">
                                            @for($i=1;$i<=31;$i++)
                                                @if($i == $profile['day'])
                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                @else
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select> 
                                    </div>
                                </div>
                            </div>


                            {{-- Ethnicity --}}
                            <div class="form-group col-md-12">
                                <label for="ethnicity">What is your ethnic background or your country of origin? *</label>
                                <select id="ethnicity" name="ethnicity" class="form-control" required>
                                    @foreach($ethnicities as $ethnic)
                                        @if($ethnic['id'] == $profile->ethnicity_id)
                                            <option value="{{ $ethnic['id'] }}" selected>{{ $ethnic['ethnicity'] }}</option>
                                        @else
                                        <option value="{{ $ethnic['id'] }}">{{ $ethnic['ethnicity'] }}</option>
                                        @endif 
                                    @endforeach                                                                           
                                </select>
                            </div>


                             {{-- Languages --}}
                             <div class="form-group col-md-12">
                                <label for="languages">What languages do you speak? *</label>          
                                <select class="form-control select2-multi" name='languages[]' id='languages' required multiple="multiple">
                                    @foreach($languages as $language)
                                        @if(in_array($language['id'], $profile->languages->pluck('id')->toarray()))
                                            <option value="{{  $language['id'] }}" selected>{{  $language['language'] }}</option>
                                        @else
                                            <option value="{{  $language['id'] }}">{{  $language['language'] }}</option>
                                        @endif
                                    @endforeach
                                </select>                                    
                            </div>   


                            {{-- Country grew up --}}
                            <div class="form-group col-md-12">
                                <label for="country_grew_up">In which country did you grow up? *</label>
                                <select id="country_grew_up" name="country_grew_up" class="form-control"  required>
                                    @foreach($grew_ups as $gup)
                                        @if($gup['id'] == $profile->countrygrewup_id)
                                            <option value="{{ $gup['id'] }}" selected>{{ $gup['country_grew_up'] }}</option> 
                                        @else
                                            <option value="{{ $gup['id'] }}">{{ $gup['country_grew_up'] }}</option>
                                        @endif
                                    @endforeach                                                                           
                                </select>
                            </div>


                            {{-- Status in canada --}}
                            <div class="form-group col-md-12">
                                <label for="status_in_canada">What is your current status in Canada? *</label>
                                <select name="status_in_canada" class="form-control" id="status_in_canada">
                                    @foreach($status_in_canada as $stcanada) 
                                        @if($stcanada["id"] == $profile->statusincanada_id)
                                            <option value="{{ $stcanada["id"] }}" selected>{{ $stcanada["status_in_canada"] }}</option>
                                        @else
                                            <option value="{{ $stcanada["id"] }}">{{ $stcanada["status_in_canada"] }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>


                            {{-- Location --}}
                            <div class="form-group col-md-12">
                                <label for="location">Where do you live in Canada? *</label>
                                <select id="location" name="location" class="form-control" required>
                                    @foreach($locations as $location)  
                                        @if($location["id"] == $profile->location_id)  
                                            <option value="{{ $location["id"] }}" selected>{{ $location["location"] }}</option>
                                        @else
                                            <option value="{{ $location["id"] }}">{{ $location["location"] }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>



                            {{-- Marital Status --}}
                            <div class="form-group col-md-12">
                                <label for="marital_status">What is your marital status? *</label>
                                <select id="marital_status" name="marital_status" class="form-control" required>                                    
                                    @foreach($marital_status as $ms) 
                                        @if($ms['id'] == $profile->maritalstatus_id)
                                            <option value="{{ $ms["id"] }}" selected>{{ $ms["marital_status"] }}</option>
                                        @else
                                            <option value="{{ $ms["id"] }}">{{ $ms["marital_status"] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>



                            {{-- has children --}}

                            <div class="form-group col-md-4">
                                <label for="haschildren">Do you have children? *</label>
                                <select id ="haschildren" name="haschildren" class="form-control" 
                                 required>
                                    @foreach(Array(0,1) as $hc)
                                        @if($hc == $profile->haschildren)
                                            <option value="{{ $hc }}" selected>@if($hc == 0) No @else Yes @endif</option>
                                        @else
                                            <option value="{{ $hc }}">@if($hc == 0) No @else Yes @endif</option>
                                        @endif
                                    @endforeach                         
                                </select>
                            </div>


                            {{-- How many children --}}
                            <div class="form-group col-md-12">
                                <label for="howmanychildren">How many children do you have? *</label>
                                <select id="howmanychildren" name="howmanychildren" class="form-control" required>  

                                    @foreach($howmanychildren as $children)                                         @if($children["id"] == $profile->howmanychildren_id)  
                                            <option value="{{ $children["id"] }}" selected>{{ $children["number_of_children"] }}</option>
                                        @else
                                            <option value="{{ $children["id"] }}">{{ $children["number_of_children"] }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>

                            {{-- How many children with you --}}

                            <div class="form-group col-md-12">
                                <label for="childrenwithyou">How many of your children live with you? *</label>
                                <select id="childrenwithyou" name="childrenwithyou" class="form-control" required>                                    
                                    @foreach($childrenwithyou as $childrenwy)                                       @if($childrenwy["id"] == $profile->childrenwithyou_id)
                                            <option value="{{ $childrenwy["id"] }}" selected>{{ $childrenwy["number_of_children_with_you"] }}</option>
                                        @else
                                            <option value="{{ $childrenwy["id"] }}">{{ $childrenwy["number_of_children_with_you"] }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>


                             {{-- Body type --}}
                             <div class="form-group col-md-12">
                                <label for="body_type">What is your body type? *</label>
                                <select  id="body_type" name="body_type" class="form-control" required>   
                                    @foreach($body_types as $bdt)
                                        @if($bdt['id'] == $profile->bodytype_id)
                                            <option value="{{ $bdt['id'] }}" selected>{{ $bdt['body_type'] }}</option>  
                                        @else
                                            <option value="{{ $bdt['id'] }}">{{ $bdt['body_type'] }}</option> 
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            {{-- Height--}}

                            <div class="form-group col-md-6">
                                <label for="height">What is your height? *</label><br> 
                                <select id="height" name="height" class="form-control" 
                                 required>
                                    @foreach(Array(3,4,5,6,) as $feet)
                                        @foreach(Array(0,1,2,3,4,5,6,7,8,9,10,11) as $inch)
                                            @if($feet.".".$inch == $profile->height)
                                                <option value="{{ $feet.".".$inch }}" selected>{{ $feet.".".$inch }}</option>
                                            @else
                                                <option value="{{ $feet.".".$inch }}">{{ $feet.".".$inch }}</option>
                                            @endif
                                        @endforeach
                                    @endforeach                   
                                </select>
                            </div>

                            {{-- Dress --}}

                            <div class="form-group col-md-12">
                                <label for="dress">What is your daily attire/outfit? *</label>
                                <select id="dress" name="dress" class="form-control" required> 
                                    @foreach($dresses as $dress)
                                        @if($dress['id'] == $profile->dress_id)
                                            <option value="{{ $dress['id'] }}" selected>{{ $dress['dress'] }}</option>  
                                        @else
                                            <option value="{{ $dress['id'] }}">{{ $dress['dress'] }}</option>  
                                        @endif
                                    @endforeach                        
                                </select>
                            </div>


                            {{-- relocate --}}
                            <div class="form-group col-md-4">
                                <label for="relocate">Are you open to relocate? *</label>
                                <select id="relocate" name="relocate" class="form-control" required>
                                    @foreach(Array(0,1) as $relocate)
                                        @if($relocate == $profile->relocate)
                                            <option value="{{ $relocate }}" selected>@if($relocate == 0) No @else Yes @endif</option>
                                        @else
                                            <option value="{{ $relocate }}">@if($relocate == 0) No @else Yes @endif</option>
                                        @endif
                                    @endforeach                     
                                </select>
                            </div>      


                            {{-- Education --}}
                            <div class="form-group col-md-12">
                                <label for="education">What is the highest eduction level you have achieved? *</label>
                                <select id="education" name="education" class="form-control" required>  
                                    @foreach($educations as $educ)
                                        @if($educ['id'] == $profile->education_id)
                                            <option value="{{ $educ['id'] }}" selected>{{ $educ['education'] }}</option>
                                        @else
                                            <option value="{{ $educ['id'] }}">{{ $educ['education'] }}</option>
                                        @endif
                                    @endforeach                    
                                </select>
                            </div>                          
                            



                             {{-- Profession --}}
                             <div class="form-group col-md-12">
                                    <label for="profession">What is your current profession/job? *</label>
                                    <select id="profession" name="profession" class="form-control"  required>
                                        @foreach($professions as $prof)
                                            @if($prof['id'] == $profile->profession_id)
                                                <option value="{{ $prof['id'] }}" selected>{{ $prof['profession'] }}</option> 
                                            @else
                                                <option value="{{ $prof['id'] }}">{{ $prof['profession'] }}</option>
                                            @endif
                                        @endforeach    
                                    </select>
                                </div>

                            

                            {{-- volunteering --}}
                            <div class="form-group col-md-12">
                                <label for="volunteering">Do you volunteer?</label>
                                <select id="volunteering" name="volunteering" class="form-control">
                                    @foreach(Array(0,1) as $volunteer)
                                        @if($volunteer == $profile->volunteering)
                                            <option value="{{ $volunteer }}" selected>@if($volunteer == 0) No @else Yes @endif</option>
                                        @else
                                            <option value="{{ $volunteer }}">@if($volunteer == 0) No @else Yes @endif</option>
                                        @endif
                                    @endforeach                                      
                                </select>
                            </div>


                            {{-- Hobbies --}}
                            <div class="form-group col-md-12">
                                <label for="hobbies">What are your hobbies? </label>          
                                <select class="form-control select2-multi" name='hobbies[]' id='hobbies' required multiple="multiple">
                                    @foreach($hobbies as $hobby)
                                        @if(in_array($hobby['id'], $profile->hobbies->pluck('id')->toarray()))
                                            <option value="{{  $hobby['id'] }}" selected>{{  $hobby['hobby'] }}</option>
                                        @else
                                            <option value="{{  $hobby['id'] }}">{{  $hobby['hobby'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>   


                             {{-- description --}}
                             <div class="form-group col-md-12">
                                <label for="self_description">Provide a brief description of yourself (minimum 100 characters and maximum 3000 characters) *</label>
                                <textarea id="self_description" name="self_description" class="form-control" cols="30" rows="10" maxlength="3000">{{ $profile->selfdescription->description }}</textarea>
                            </div>  
                            
                            {{-- What you are looking for --}}
                            <div class="form-group col-md-12">
                                <label for="looking_for">Provide a brief description of what you are looking for (minimum 100 characters and maximum 3000 characters)*</label>
                                <textarea id="looking_for" name="looking_for" class="form-control" cols="30" rows="10" maxlength="3000">{{ $profile->lookingfor->what_want }}</textarea>
                            </div>      



                            <button id="submit_button" type="submit" class="btn btn-info">Update Profile</button>
                          </form>






                    {{-- Form ends here --}}











                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section("javascript")

<script>
    $( document ).ready(function() {
        // Enable the submit button
        enable_submit();
        function enable_submit(){
            let first_three = $("#phone-first-three").val();
            let second_three = $("#phone-second-three").val();
            let last_four = $("#phone-four").val();
            if(first_three.length>=3 && second_three.length>=3 && last_four.length>=4){
                $("#submit_button").attr('disabled',false);
                $('#phone-valid').empty();
                $('#phone-valid').append('<button class="btn btn-success btn-block" disabled>Valid</button>')
            }else{
                $("#submit_button").attr('disabled',true);
                $('#phone-valid').empty();
                
                $('#phone-valid').append('<button class="btn btn-danger d-block" disabled>Not valid</button>')
            }
        }; 


        // Check phone number
        $(".phone-number-three").keyup(function(){
            let current_value = $(this).val().split("");
            let last_element = current_value[current_value.length-1]            
            if(!["0","1","2","3","4","5","6","8","9"].includes(last_element) || current_value.length >3){
                current_value.pop();                
                $(this).val(current_value.join(""));                
            }
            enable_submit();            
        })
        $(".phone-number-four").keyup(function(){
            let current_value = $(this).val().split("");
            let last_element = current_value[current_value.length-1]            
            if(!["0","1","2","3","4","5","6","8","9"].includes(last_element) || current_value.length >4){
                current_value.pop();                
                $(this).val(current_value.join(""));                
            }  
            enable_submit()          
        })


        // Check for leap year
        $("#month").change(function(){
            let year = $("#year").val();
            let month = $("#month").val();            
            if(month == 2){                
                if(((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)){                    
                    $('#day').empty();                    
                    for(i=1;i<=29;i++){
                        $('#day').append('<option value="' + i + '">' + i + '</option>')
                    }                
                }else{
                    $('#day').empty();
                    for(i=1;i<=28;i++){
                        $('#day').append('<option value="' + i + '">' + i + '</option>')
                    } 
                }               
            }else if(["1","3","5","7","8","10","12"].includes(month)){
                
                $('#day').empty();
                    for(i=1;i<=31;i++){
                        $('#day').append('<option value="' + i + '">' + i + '</option>')
                } 
            }else if(["4","6","9","11"].includes(month)){
                $('#day').empty();
                    for(i=1;i<=30;i++){
                        $('#day').append('<option value="' + i + '">' + i + '</option>')
                } 
            }
        });

        $("#year").change(function(){
            let year = $("#year").val();
            let month = $("#month").val();                                      
            if(((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)){
                if(month == 2){                 
                    $('#day').empty();                    
                    for(i=1;i<=29;i++){
                        $('#day').append('<option value="' + i + '">' + i + '</option>')
                    }
                }else if(["1","3","5","7","8","10","12"].includes(month)){
                    $('#day').empty();
                        for(i=1;i<=31;i++){
                            $('#day').append('<option value="' + i + '">' + i + '</option>')
                    } 
                }else if(["4","6","9","11"].includes(month)){
                    $('#day').empty();
                        for(i=1;i<=30;i++){
                            $('#day').append('<option value="' + i + '">' + i + '</option>')
                    } 
                }             
            }else{ 
                if(month == 2){                   
                    $('#day').empty();
                    for(i=1;i<=28;i++){
                        $('#day').append('<option value="' + i + '">' + i + '</option>')
                    } 
                }
                else if(["1","3","5","7","8","10","12"].includes(month)){
                    $('#day').empty();
                        for(i=1;i<=31;i++){
                            $('#day').append('<option value="' + i + '">' + i + '</option>')
                    } 
                }else if(["4","6","9","11"].includes(month)){
                    $('#day').empty();
                        for(i=1;i<=30;i++){
                            $('#day').append('<option value="' + i + '">' + i + '</option>')
                    } 
                }
            }               
            
        }); 


        // Deal with the has children and number of children        
        $("#haschildren").change(function(){           
            if($(this).val() == 1){                
                $("#howmanychildren option[value='1']").remove();                
                
            }else{
                $("#howmanychildren").prepend('<option value="1" selected>None</option>');                
                $("#childrenwithyou option[value='1']").prop("selected","selected");
                
            }
        });


        // Number of children with you cannot be higher than the total number of children you have
        $("#howmanychildren").change(function(){
            if( $("#haschildren").val() == 0){
                if($(this).val()>1){
                    alert("The number cannot be change since you have no children")
                    $("#howmanychildren option[value='1']").prop("selected", "selected");
                }
            }
            $("#childrenwithyou option[value='1']").prop("selected", "selected");
        });

        $("#childrenwithyou").change(function(){
            var numChildren = $("#howmanychildren").val();
            if($(this).val()>numChildren){
                alert("The number of children with you cannot be higher than you actual number of children")
                $("#childrenwithyou option[value='1']").prop("selected", "selected")
            }

            if( $("#haschildren").val() == 0){
                if($(this).val()>0){
                    alert("The number cannot be change since you have no children")
                    $("#childrenwithyou option[value='1']").prop("selected", "selected")
                }
            }
        });


        // Deal with Dress male female               
        $("#sex").change(function(){           
            if($(this).val() == 1){                
                $("#dress [value='1']").prop("selected", "selected");  
            }
        });
        $("#dress").change(function(){                       
            if($(this).val() > 1 &&  $("#sex").val() == 1){   
                alert("This option is not applicable")             
                $("#dress [value='1']").prop("selected", "selected");  
            }
        });
        

    });

    
</script>




  <script src="{{ asset('js/select2.min.js')}}"></script>

  <script>
      $(".select2-multi").select2();
  </script>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">        
@endsection






