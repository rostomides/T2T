<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="ReportModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="ReportModal">Report {{ $profile->user->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">            
            
            <form action="{{ route('flag') }}" method="POST">
                @csrf
                {{-- description --}}
                <div class="form-group col-md-12">
                    <label for="self_description">Why are you reporting {{ $profile->user->name }} *</label>
                    <textarea name="report_description" class="form-control" cols="30" rows="10" required></textarea>
                </div> 

                </div>
                <div class="modal-footer">
                    <input type="hidden" value="{{ $profile->id }}" name="current_user_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel and close</button>
                    <button  class="btn btn-danger" type="submit">Report</button>
                </div>
            </form>
        
        </div>
    </div>
</div>