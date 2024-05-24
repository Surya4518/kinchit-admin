<div id="service_artical_create_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="create_service_form">
                <div class="row">
                    <div class="col-12 md-form mb-5">
                    <label for="">Service Title : </label>
                    <input type="text" class="form-control" name="service_title" id="service_title">
                    <p id="service_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Meta Title : </label>
                    <input type="text" class="form-control" name="meta_title" id="meta_title">
                    <p id="meta_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Meta Description : </label>
                    <textarea class="form-control" name="meta_description" id="meta_description"></textarea>
                    <p id="meta_description_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Meta Keyword : </label>
                    <textarea class="form-control" name="meta_key" id="meta_key"></textarea>
                    <p id="meta_key_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="CreateService()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
