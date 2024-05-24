<div id="enpani_category_create_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="create_enpani_category_form">
            <div class="md-form mb-5">
                <label for="">Category Name : </label>
                <input type="text" class="form-control" placeholder="Enter the category name" name="enpani_category_name" id="enpani_category_name">
                <p class="validate_errors" id="enpani_category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Publish Status : </label>
                <select class="form-control" name="enpani_category_publish_status" id="enpani_category_publish_status">
                    <option value="">Select Status</option>
                    <option value="publish">Publish</option>
                    <option value="pending">Pending</option>
                </select>
                <p class="validate_errors" id="enpani_category_publish_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="CreateEnpaniCategory()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
