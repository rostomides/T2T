<ul class="list-group-flush pl-0 about-panel" >

    <li class="list-group-item">
        Status in Canada: {{ $profile->statusincanada->status_in_canada }}
    </li>

    <li class="list-group-item">
        Ethnicity:  {{ $profile->ethnicity->ethnicity }}
    </li>

    <li class="list-group-item">
        Grew up in :  {{ $profile->countrygrewup->country_grew_up }}
    </li>
    
    <li class="list-group-item">
        Languages : 
        <ul>
            @foreach($profile->languages as $language)
                <li>{{ $language->language }}</li>

            @endforeach
                
        </ul> 
        
    </li>
    
    <li class="list-group-item">
        Height:  {{ $profile->height }}
    </li>

    <li class="list-group-item">
        Body type:  {{ $profile->bodytype->body_type }}
    </li>

    <li class="list-group-item">
        Marital status:  {{ $profile->maritalstatus->marital_status }} 
    </li>

    @if($profile->haschildren == 1)
        <li class="list-group-item">
            Children:  Yes                                
        </li>
        <li class="list-group-item">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    How many total:  {{ $profile->howmanychildren->number_of_children }} 
                </li>
                <li class="list-group-item">
                    How many live with me:  {{ $profile->childrenwithyou->number_of_children_with_you }}
                </li>
            </ul>
        </li>
    @else

        <li class="list-group-item">
            Has children:  No                              
        </li>
        
    @endif
    

    <li class="list-group-item">
        Ready to relocate: @if($profile->relocate == 0) No @else Yes @endif
    </li>

    <li class="list-group-item">
        Education:  {{ $profile->education->education }}
    </li>    

    

    @if($profile->sex_id == 1)
    <li class="list-group-item">
        Daily dress:  {{ $profile->dress->dress }}
    </li>
    @endif
    
    

    <li class="list-group-item">
        Hobbies : 
        <ul>
            @foreach($profile->hobbies as $hobby)
                <li>{{ $hobby->hobby }}</li>

            @endforeach
                
        </ul> 
        
    </li>

   



</ul>
