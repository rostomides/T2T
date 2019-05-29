

<div class="modal fade" id="feedback-modal" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="feedbackModal">Your feedback:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">            
            
            <form action="{{ route('feedback') }}" method="POST">
                @csrf
                {{-- description --}}
                <div class="form-group col-md-12">
                    <label for="self_description">Type your message here:</label>
                    <textarea name="feedback" class="form-control" cols="30" rows="10" required></textarea>
                </div> 

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel and close</button>
                    <button  class="btn btn-danger" type="submit">submit</button>
                </div>
            </form>
        
        </div>
    </div>
</div>