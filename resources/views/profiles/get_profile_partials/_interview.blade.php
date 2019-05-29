   
@if(auth()->user()->role_id < 3)
<div class="container">      
    <hr> 
    <h3>Phone number: {{ $profile->phone}}</h3>
    <h3>Email: {{ $profile->user->email}}</h3>
    <div class="row justify-content-center">
        
        
        <div class="col-md-12">
            <form action="{{ route('save_interview_report') }}" method="POST">
                <div class="form-group">
                    <label for="report">Interview notes</label>
                        <textarea name="report" class="form-control"  rows="10"> 
                            @if(isset($interview_report))
                                {{ $interview_report->report }}
                            @endif
                        </textarea>
                </div> 
                @csrf
                <input type="hidden" name="profil_id" value="{{ $profile->id }}">

                <button class="btn btn-primary" type="submit" >Save interview report</button>

            </form>
        </div>
    </div>
</div>
@endif