<div class="modal fade" id="reject_request_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Reject the Approval</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="border: none;background: transparent;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <textarea name="request_reject_reason" class="form-control" placeholder="Please enter your reason to reject the request" id="request_reject_reason" cols="30" rows="10"></textarea>
                    <p id="request_reject_reason_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <input type="hidden" name="request_id" id="request_id">
                <button class="btn btn-secondary" onclick="RejectTheRequest()">Submit</button>
            </div>
        </div>
    </div>
</div>
