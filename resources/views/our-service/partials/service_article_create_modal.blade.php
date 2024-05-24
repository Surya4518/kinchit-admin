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
                    <label for="">Service Content : </label>
                    <textarea class="form-control" name="content" id="content"></textarea>
                    <p id="content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Status : </label>
                  <select name="status" class="form-control" id="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                    <p id="status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Shord Order : </label>
                    <input type="number" class="form-control" name="shord_order" id="shord_order">
                    <p id="shord_order_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
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
