@extends('layouts.app')

@section('content')




<div class="container">

        {{-- Include the messages --}}
        




    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome , create your profile </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    {{-- Form strats here --}}

                    <form method="POST" action="{{ route('store_profil') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">   


                            {{-- Picture  --}}
                            <div class="form-group col-md-12">
                                <label for="picture">Please Select your main picture *</label>
                                <input id="picture" type="file" class="form-control" name="picture" 
                                required>
                                <span>
                                <small>* Please provide a full size picture without sunglasses (maximum size: 2mb) </small>
                                </span>
                            </div>

                            {{-- Phone number --}}
                            <div class="form-group col-md-12">
                                <label for="phone">What is your phone number? *</label>
                                <div class="form-row">
                                    <div class="col-3 form-group">
                                        <input  type="text" class="form-control phone-number-three phone" id ="phone-first-three" name="phone-first-three"  
                                        value="{{ old('phone-first-three') }}" required placeholder="3 digits">
                                    </div>                                   
                                
                                    <div class="col-3 form-group"> 
                                        <input  type="text" class="form-control phone-number-three phone" name="phone-second-three" id="phone-second-three"  
                                        value="{{ old('phone-second-three') }}" required placeholder="3 digits">                                        
                                    </div>


                                    <div class="col-3 form-group"> 
                                        <input  type="text" class="form-control phone-number-four phone" name="phone-four"  id="phone-four"
                                        value="{{ old('phone-four') }}" required placeholder="4 digits">
                                    </div>

                                    <div class="col-3 form-group" id="phone-valid">
                                         
                                    </div>
                                </div>  
                            </div> 

                             {{-- Sex --}}
                             <div class="form-group col-md-4">
                                <label for="sex">Are you a male or a female ? *</label>
                                <select id="sex" name="sex" class="form-control" 
                                value="{{ old('sex') }}"required>
                                    <option selected></option>
                                    @foreach($sexes as $sex)
                                        <option value="{{ $sex['id'] }}">{{ $sex['sex'] }}</option>  

                                    @endforeach                                    
                                </select>
                            </div>


                            {{-- Age --}}

                            <div class="form-group col-md-12">
                                <label for="birthday">What is your date of birth? *</label>
                                <div class="form-row">
                                    <div class="col-4 form-group">
                                        <label for="year">Year *</label>
                                        <select name="year" class="form-control" id="year">
                                            @for($i=(date("Y")-18);$i>=1940;$i--)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select> 
                                    </div>
                                    <div class="col-4 form-group">
                                        <label for="month">Month *</label>
                                        <select name="month" class="form-control" id="month">
                                            @for($i=1;$i<=12;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select> 
                                    </div>
                                    <div class="col-4 form-group">
                                        <label for="day">Day *</label>
                                        <select name="day" class="form-control" id="day">
                                            @for($i=1;$i<=31;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select> 
                                    </div> 

                                </div>


                            </div>




                            {{-- Ethnicity --}}
                            <div class="form-group col-md-12">
                                <label for="ethnicity">What is your ethnic background or your country of origin? *</label>
                                <select id="ethnicity" name="ethnicity" class="form-control" value="{{ old('ethnicity') }}" required>
                                    <option selected></option>
                                    @foreach($ethnicities as $ethnic)
                                        <option value="{{ $ethnic['id'] }}">{{ $ethnic['ethnicity'] }}</option> 
                                    @endforeach                                                                           
                                </select>
                            </div>


                             {{-- Languages --}}
                             <div class="form-group col-md-12">
                                <label for="languages">What languages do you speak? *</label>          
                                <select class="form-control select2-multi" name='languages[]' id='languages' required multiple="multiple" value="{{ old('languages') }}">
                                    @foreach($languages as $language)
                                        <option value="{{  $language['id'] }}">{{  $language['language'] }}</option>
                                    @endforeach
                                </select>                                    
                            </div>   


                            {{-- Country grew up --}}
                            <div class="form-group col-md-12">
                                <label for="country_grew_up">In which country did you grew up? *</label>
                                <select id="country_grew_up" name="country_grew_up" class="form-control" value="{{ old('country_grew_up') }}"  required>
                                    <option selected></option>
                                    @foreach($grew_ups as $gup)
                                        <option value="{{ $gup['id'] }}">{{ $gup['country_grew_up'] }}</option> 
                                    @endforeach                                                                           
                                </select>
                            </div>


                            {{-- Status in canada --}}
                            <div class="form-group col-md-12">
                                <label for="status_in_canada">What is your current status in Canada? *</label>
                                <select name="status_in_canada" class="form-control" value="{{ old('status_in_canada') }}" id="status_in_canada">
                                    <option selected></option>
                                    @foreach($status_in_canada as $stcanada)                                        
                                        <option value="{{ $stcanada["id"] }}">{{ $stcanada["status_in_canada"] }}</option>
                                    @endforeach

                                </select>
                            </div>


                            {{-- Location --}}
                            <div class="form-group col-md-12">
                                <label for="location">Where in Canada do you live? *</label>
                                <select id="location" name="location" class="form-control" value="{{ old('location') }}" required>
                                    <option selected></option>
                                    @foreach($locations as $location)                                        
                                        <option value="{{ $location["id"] }}">{{ $location["location"] }}</option>
                                    @endforeach

                                </select>
                            </div>



                            {{-- Marital Status --}}
                            <div class="form-group col-md-12">
                                <label for="marital_status">What is your marital status? *</label>
                                <select id="marital_status" name="marital_status" class="form-control" value="{{ old('marital_status') }}" required>
                                    <option selected></option>
                                    @foreach($marital_status as $ms)                                        
                                        <option value="{{ $ms["id"] }}">{{ $ms["marital_status"] }}</option>
                                    @endforeach

                                </select>
                            </div>



                            {{-- has children --}}

                            <div class="form-group col-md-4">
                                <label for="haschildren">Do you have children? *</label>
                                <select id ="haschildren" name="haschildren" class="form-control" 
                                value="{{ old("haschildren") }}" required>
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>                                    
                                </select>
                            </div>


                            {{-- How many children --}}
                            <div class="form-group col-md-12">
                                <label for="howmanychildren">How many children do you have? *</label>
                                <select id="howmanychildren" name="howmanychildren" class="form-control" value="{{ old("howmanychildren") }}" required>  

                                    @foreach($howmanychildren as $children)                                       
                                        <option value="{{ $children["id"] }}">{{ $children["number_of_children"] }}</option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- How many children with you --}}

                            <div class="form-group col-md-12">
                                <label for="childrenwithyou">How many children live with you? *</label>
                                <select id="childrenwithyou" name="childrenwithyou" class="form-control" 
                                value="{{ old("childrenwithyou") }}">
                                    
                                    @foreach($childrenwithyou as $childrenwy)                                        
                                        <option value="{{ $childrenwy["id"] }}">{{ $childrenwy["number_of_children_with_you"] }}</option>
                                    @endforeach

                                </select>
                            </div>





                             {{-- Body type --}}

                             <div class="form-group col-md-12">
                                <label for="body_type">What is body type? *</label>
                                <select  id="body_type" name="body_type" class="form-control" value="{{ old("body_type") }}" required>
                                    <option selected></option>
                                    @foreach($body_types as $bdt)
                                    <option value="{{ $bdt['id'] }}">{{ $bdt['body_type'] }}</option>  

                                    @endforeach

                                                                        
                                </select>
                            </div>


                            {{-- Height--}}

                            <div class="form-group col-md-6">
                                <label for="height">What is your height? *</label><br> 
                                <select id="height" name="height" class="form-control" 
                                value="{{ old("height") }}" required>

                                    @foreach(Array(3,4,5,6) as $feet)
                                        @foreach(Array(0,1,2,3,4,5,6,7,8,9,10,11) as $inch)
                                            @if($feet == 5 && $inch == 0)
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
                                <label for="dress">What is your daily atteire? *</label>
                                <select id="dress" name="dress" class="form-control" 
                                value="{{ old("dress") }}" required>
                                    <option selected></option>
                                    @foreach($dresses as $dress)
                                        <option value="{{ $dress['id'] }}">{{ $dress['dress'] }}</option>  

                                    @endforeach

                                                                        
                                </select>
                            </div>


                            {{-- relocate --}}
                            <div class="form-group col-md-4">
                                <label for="relocate">Are you open to relocate? *</label>
                                <select id="relocate" name="relocate" class="form-control" 
                                value="{{ old("relocate") }}" required>
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>                                    
                                </select>
                            </div>      
                            


                            {{-- Education --}}
                            <div class="form-group col-md-12">
                                <label for="education">What is the highest eduction level you have achieved? *</label>
                                <select id="education" name="education" class="form-control" 
                                value="{{ old("education") }}" required>
                                    <option selected></option>
                                    @foreach($educations as $educ)
                                    <option value="{{ $educ['id'] }}">{{ $educ['education'] }}</option>   

                                    @endforeach

                                                                     
                                </select>
                            </div>                          
                            



                             {{-- Profession --}}
                             <div class="form-group col-md-12">
                                    <label for="profession">What is your profession? *</label>
                                    <select id="profession" name="profession" class="form-control"  value="{{ old("profession") }}" required>
                                        <option selected></option>
                                        @foreach($professions as $prof)
                                        <option value="{{ $prof['id'] }}">{{ $prof['profession'] }}</option>  
    
                                        @endforeach                                                                            
                                    </select>
                                </div>

                            

                            {{-- volunteering --}}
                            <div class="form-group col-md-12">
                                <label for="volunteering">Do you volunteer?</label>
                                <select id="volunteering" name="volunteering" class="form-control" value="{{ old("volunteering") }}">
                                    <option selected></option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>                                    
                                </select>
                            </div>


                            {{-- Hobbies --}}
                            <div class="form-group col-md-12">
                                <label for="hobbies">What are your hobbies? </label>          
                                <select class="form-control select2-multi" name='hobbies[]' id='hobbies' required multiple="multiple" value="{{ old("hobbies") }}">
                                    @foreach($hobbies as $hobby)
                                        <option value="{{ $hobby['id'] }}" >{{ $hobby['hobby'] }}</option>
                                    @endforeach
                                </select>
                                
                            </div>   


                             {{-- description --}}
                             <div class="form-group col-md-12">
                                <label for="self_description">Provide a brief description of yourself *</label>
                                <textarea id="self_description" name="self_description" class="form-control" cols="30" rows="10" value="{{ old("self_description") }}" ></textarea>
                            </div>  
                            
                            {{-- What you are looking for --}}
                            <div class="form-group col-md-12">
                                <label for="looking_for">Provide a brief description of what you are looking for *</label>
                                <textarea id="looking_for" name="looking_for" class="form-control" cols="30" rows="10" value="{{ old("looking_for") }}"></textarea>
                            </div>      



                            <button id="submit_button" type="submit" class="btn btn-primary" disabled>Create profile</button>
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
            if(!["0","1","2","3","4","5","6","7","8","9"].includes(last_element) || current_value.length >3){
                current_value.pop();                
                $(this).val(current_value.join(""));                
            }
            enable_submit();            
        })
        $(".phone-number-four").keyup(function(){
            let current_value = $(this).val().split("");
            let last_element = current_value[current_value.length-1]            
            if(!["0","1","2","3","4","5","6","7","8","9"].includes(last_element) || current_value.length >4){
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


@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">        
@endsection






@endsection