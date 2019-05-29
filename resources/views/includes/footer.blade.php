<footer class="footer bg-info mt-5 p-3">
    
        <div class="row">
            @if(Auth::check())
                <div class="col-8">
            @else
                <div class="col-12">
            @endif
            
                <div class="text-center">
                    <h5 class="text-white">Tayeboon2Tayebat</h5>
                </div>
                
                    
                <div class="text-center" style="line-height:200% !important;">
                        <img src="{{ asset('svg/icons8-email-96.png') }}" alt="email icon" class="footer-icon d-inline">   
                        <p class="d-inline text-white f-h">tayeboon2tayebat@gmail.com</p> 

                        <img src="{{ asset('svg/icons8-phone-96.png') }}" alt="phone icon"   class=" footer-icon d-inline">   
                        <p class="d-inline text-white f-h">123-456-7899</p><br>

                        <img src="{{ asset('svg/icons8-postal-96.png') }}" alt="address icon"   class=" footer-icon">   
                        <p class="d-inline text-white f-h">London, Ontario, Canada</p>
                </div>
            </div>    
            @if(Auth::check())
                <div class="col-4 text-white text-center" style="line-height:200% !important;">
                    <p class="mb-0">Please send us your feedback:</p>
                    <button class="btn btn-warning btn-block mt-0" data-toggle="modal" data-target="#feedback-modal"> Here
                    </button>
                </div>
            @endif
        </div>
        

           
            
                   
    
</footer>