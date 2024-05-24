<div class="modal fade" id="send_request_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Send Request</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <input type="text" readonly class="form-control" name="for_user_id" id="for_user_id">
          </div>
        <div class="md-form mb-5">
          {{-- <i class="fas fa-envelope prefix grey-text"></i> --}}
          {{-- <input type="email" id="defaultForm-email" class="form-control validate">
          <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label> --}}
          <select name="request_types" id="request_types">
            <option value="">Select Request Type</option>
        </select>
        <p id="request_types_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
        </div>
        <div class="md-form mb-5">
            <textarea class="form-control" placeholder="Type your reason for the approval request" name="approval_request_reason" id="approval_request_reason" cols="30" rows="10"></textarea>
          </div>

        {{-- <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <input type="password" id="defaultForm-pass" class="form-control validate">
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Your password</label>
        </div> --}}

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-secondary" onclick="SendRequest()">Submit</button>
      </div>
    </div>
  </div>
</div>

