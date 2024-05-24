<div class="modal fade" id="approve_request_modal_volunteer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Change Members</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="border: none;background: transparent;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <input type="text" readonly class="form-control" name="volunteer_request_from_user_id"
                        id="volunteer_request_from_user_id">
                </div>
                <div class="md-form mb-5">
                    <select name="volunteer_request_volunteers" id="volunteer_request_volunteers">
                        <option value="">Select volunteer</option>
                        @for ($i = 0; $i < $volunteer->count(); $i++)
                            <option value="{{ $volunteer[$i]->user_login }}">{{ $volunteer[$i]->user_login }}</option>
                        @endfor
                    </select>
                    <p id="volunteer_request_volunteers_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <input type="hidden" name="approval_request_id" id="approval_request_id">
                <button class="btn btn-secondary" onclick="ChangeMembersToAnotherVolunteer()">Submit</button>
            </div>
        </div>
    </div>
</div>
