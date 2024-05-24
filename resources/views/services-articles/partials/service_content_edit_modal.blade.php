

<div id="service_content_edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Service Content</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="edit_service_content_form">
            <div class="md-form mb-5">
                <label for="">Content Title : </label>
                <input type="text" class="form-control" name="edit_service_content_title" id="edit_service_content_title">
                <p id="edit_service_content_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Content Title : </label>
                <textarea name="edit_service_content_description" id="edit_service_content_description" class="summernote" cols="30" rows="10"></textarea>
                <input type="hidden" name="edit_service_content_id" id="edit_service_content_id">
                <p id="edit_service_content_description_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="UpdateServiceContentData()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-dialog .// -->
  </div> <!-- modal.// -->
