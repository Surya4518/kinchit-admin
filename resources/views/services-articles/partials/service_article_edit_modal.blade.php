<div id="service_artical_edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="edit_service_form">
              <div class="row">
                <div class="col-12 md-form mb-3">
                <label for="">Service Title : </label>
                <input type="text" class="form-control" name="edit_service_title" id="edit_service_title">
                <p id="edit_service_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="col-12 md-form mb-3">
                <label for="">Meta Title : </label>
                <input type="text" class="form-control" name="edit_meta_title" id="edit_meta_title">
                <p id="edit_meta_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
               <div class="col-12 md-form mb-3">
                <label for="">Url : </label>
                <input type="text" class="form-control" name="edit_meta_url" id="edit_meta_url">
                <p id="page_slug_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="col-12 md-form mb-3">
                <label for="">Meta Description : </label>
                <textarea class="form-control" name="edit_meta_description" id="edit_meta_description"></textarea>
                <p id="edit_meta_description_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="col-12 md-form mb-3">
                <label for="">Meta Keyword : </label>
                <textarea class="form-control" name="edit_meta_key" id="edit_meta_key"></textarea>
                <p id="edit_meta_key_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                <input type="hidden" name="edit_service_id" id="edit_service_id">
              </div>
            </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="UpdateTheDataOfService()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
